<?php

namespace PhpPact\Core\BinaryManager\Downloader;

use Exception;
use PhpPact\Core\BinaryManager\Model\BinaryScripts;
use Symfony\Component\Filesystem\Filesystem;
use ZipArchive;

/**
 * Download the Ruby Standalone binaries for Windows.
 * Class BinaryDownloaderWindows
 */
class BinaryDownloaderWindows implements BinaryDownloaderInterface
{
    /**
     * @inheritDoc
     */
    public function checkEligibility(): bool
    {
        return \strtoupper(\substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * @inheritDoc
     */
    public function install(string $destinationDir): BinaryScripts
    {
        $fs = new Filesystem();

        if ($fs->exists($destinationDir . DIRECTORY_SEPARATOR . 'pact') === false) {
            $version      = '1.22.1';
            $fileName     = "pact-{$version}-win32.zip";
            $tempFilePath = \sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;

            $this
                ->download($fileName, $tempFilePath)
                ->extract($tempFilePath, $destinationDir)
                ->deleteCompressed($tempFilePath);
        }

        $binDir  = $destinationDir . DIRECTORY_SEPARATOR . 'pact' . DIRECTORY_SEPARATOR . 'bin';
        $scripts = new BinaryScripts(
             $binDir . DIRECTORY_SEPARATOR . 'pact-mock-service.bat'
        );

        return $scripts;
    }

    /**
     * Download the binaries.
     *
     * @param string $fileName     name of the file to be downloaded
     * @param string $tempFilePath location to download the file
     *
     * @throws Exception
     *
     * @return BinaryDownloaderWindows
     */
    private function download(string $fileName, string $tempFilePath): self
    {
        $uri  = "https://github.com/pact-foundation/pact-ruby-standalone/releases/download/v1.22.1/{$fileName}";
        $data = \file_get_contents($uri);

        $result = \file_put_contents($tempFilePath, $data);

        if ($result === false) {
            throw new Exception('Failed to download file.');
        }

        return $this;
    }

    /**
     * Uncompress the temp file and install the binaries in the destination directory.
     *
     * @param string $sourceFile
     * @param string $destinationDir
     *
     * @return BinaryDownloaderWindows
     * @return string
     */
    private function extract(string $sourceFile, string $destinationDir): self
    {
        $zip = new ZipArchive();

        if ($zip->open($sourceFile)) {
            $zip->extractTo($destinationDir);
            $zip->close();
        }

        return $this;
    }

    /**
     * Delete the temp file.
     *
     * @param string $filePath
     *
     * @return BinaryDownloaderWindows
     */
    private function deleteCompressed(string $filePath): self
    {
        $fs = new Filesystem();
        $fs->remove($filePath);

        return $this;
    }
}
