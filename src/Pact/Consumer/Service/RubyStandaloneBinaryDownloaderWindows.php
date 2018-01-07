<?php

namespace Pact\Consumer\Service;

use Exception;
use Pact\Consumer\Model\RubyStandaloneBinaryScripts;
use Symfony\Component\Filesystem\Filesystem;
use ZipArchive;

/**
 * Download the Ruby Standalone binaries for Windows.
 * Class RubyStandaloneBinaryDownloaderWindows
 * @package Pact\Consumer\Service
 */
class RubyStandaloneBinaryDownloaderWindows implements RubyStandaloneBinaryDownloaderInterface
{
    /**
     * @inheritDoc
     */
    public function checkEligibility(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * @inheritDoc
     */
    public function install(string $destinationDir): RubyStandaloneBinaryScripts
    {
        $fs = new Filesystem();

        if ($fs->exists($destinationDir . DIRECTORY_SEPARATOR . 'pact') === false) {
            $version = '1.22.1';
            $fileName = "pact-{$version}-win32.zip";
            $tempFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR  . $fileName;

            $this
                ->download($fileName, $tempFilePath)
                ->uncompress($tempFilePath, $destinationDir)
                ->deleteCompressed($tempFilePath);
        }

        $binDir = $destinationDir . DIRECTORY_SEPARATOR . 'pact' . DIRECTORY_SEPARATOR . 'bin';
        $scripts = new RubyStandaloneBinaryScripts(
             $binDir . DIRECTORY_SEPARATOR . 'pact-mock-service.bat'
        );

        return $scripts;
    }

    /**
     * Download the binaries.
     * @param string $fileName Name of the file to be downloaded.
     * @param string $tempFilePath Location to download the file.
     * @return RubyStandaloneBinaryDownloaderWindows
     * @throws Exception
     */
    private function download(string $fileName, string $tempFilePath): RubyStandaloneBinaryDownloaderWindows
    {
        $uri = "https://github.com/pact-foundation/pact-ruby-standalone/releases/download/v1.22.1/{$fileName}";
        $data = file_get_contents($uri);

        $result = file_put_contents($tempFilePath, $data);

        if ($result === false) {
            throw new Exception("Failed to download file.");
        }

        return $this;
    }

    /**
     * Uncompress the temp file and install the binaries in the destination directory.
     * @param string $sourceFile
     * @param string $destinationDir
     * @return RubyStandaloneBinaryDownloaderWindows
     * @return string
     */
    private function uncompress(string $sourceFile, string $destinationDir): RubyStandaloneBinaryDownloaderWindows
    {
        $zip = new ZipArchive();

        if ($zip->open($sourceFile)) {
            $zip->extractTo($destinationDir);
            $zip->close();
        };

        return $this;
    }

    /**
     * Delete the temp file.
     * @return RubyStandaloneBinaryDownloaderWindows
     * @param string $filePath
     */
    private function deleteCompressed(string $filePath): RubyStandaloneBinaryDownloaderWindows
    {
        $fs = new Filesystem();
        $fs->remove($filePath);

        return $this;
    }
}
