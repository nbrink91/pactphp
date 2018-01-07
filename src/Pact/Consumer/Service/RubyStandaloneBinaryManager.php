<?php

namespace Pact\Consumer\Service;

use Exception;
use Pact\Consumer\Model\RubyStandaloneBinaryScripts;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Manage Ruby Standalone binaries.
 * Class RubyStandaloneBinaryManager
 * @package Pact\Consumer\Service
 */
class RubyStandaloneBinaryManager
{
    /** @var RubyStandaloneBinaryDownloaderInterface[] */
    private $downloaders = [];

    /**
     * Destination directory for PACT folder.
     * @var string
     */
    private $destinationDir;

    public function __construct(string $destinationDir)
    {
        $this->destinationDir = $destinationDir;
        $this->downloaders[] = new RubyStandaloneBinaryDownloaderWindows();
    }

    /**
     * Add a single downloader.
     * @param RubyStandaloneBinaryDownloaderInterface $downloader
     * @return RubyStandaloneBinaryManager
     */
    public function addDownloader(RubyStandaloneBinaryDownloaderInterface $downloader): RubyStandaloneBinaryManager
    {
        $this->downloaders[] = $downloader;
        return $this;
    }

    /**
     * Overwrite default downloaders.
     * @param array $downloaders
     * @return RubyStandaloneBinaryManager
     */
    public function setDownloaders(array $downloaders): RubyStandaloneBinaryManager
    {
        $this->downloaders = $downloaders;
        return $this;
    }

    /**
     * Install.
     * @return RubyStandaloneBinaryScripts
     */
    public function install()
    {
        $downloader = $this->getDownloader();
        return $downloader->install($this->destinationDir);
    }

    /**
     * Uninstall.
     */
    public function uninstall()
    {
        $fs = new Filesystem();
        $fs->remove($this->destinationDir . DIRECTORY_SEPARATOR . 'pact');
    }

    /**
     * Get the first downloader that meets the systems eligibility.
     * @return RubyStandaloneBinaryDownloaderInterface
     * @throws Exception
     */
    private function getDownloader(): RubyStandaloneBinaryDownloaderInterface
    {
        /**
         * Reverse the order of the downloaders so that the ones added last are checked first.
         * @var RubyStandaloneBinaryDownloaderInterface[] $downloaders
         */
        $downloaders = array_reverse($this->downloaders);
        foreach ($downloaders as $downloader) {
            if ($downloader->checkEligibility()) {
                return $downloader;
            }
        }

        throw new Exception('No eligible downloader found for Mock Server binaries.');
    }
}
