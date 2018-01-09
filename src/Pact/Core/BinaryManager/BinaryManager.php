<?php

namespace Pact\Core\BinaryManager;

use Exception;
use Pact\Core\BinaryManager\Downloader\BinaryDownloaderInterface;
use Pact\Core\BinaryManager\Downloader\BinaryDownloaderWindows;
use Pact\Core\BinaryManager\Exception\NoDownloaderFoundException;
use Pact\Core\BinaryManager\Model\BinaryScripts;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Manage Ruby Standalone binaries.
 * Class BinaryManager
 * @package Pact\BinaryManager
 */
class BinaryManager
{
    /** @var BinaryDownloaderInterface[] */
    private $downloaders = [];

    /**
     * Destination directory for PACT folder.
     * @var string
     */
    private $destinationDir;

    public function __construct()
    {
        $this->destinationDir = sys_get_temp_dir();
        $this->downloaders[] = new BinaryDownloaderWindows();
    }

    /**
     * Add a single downloader.
     * @param BinaryDownloaderInterface $downloader
     * @return BinaryManager
     */
    public function addDownloader(BinaryDownloaderInterface $downloader): BinaryManager
    {
        $this->downloaders[] = $downloader;
        return $this;
    }

    /**
     * Overwrite default downloaders.
     * @param array $downloaders
     * @return BinaryManager
     */
    public function setDownloaders(array $downloaders): BinaryManager
    {
        $this->downloaders = $downloaders;
        return $this;
    }

    /**
     * Install.
     * @return BinaryScripts
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
     * @return BinaryDownloaderInterface
     * @throws Exception
     */
    private function getDownloader(): BinaryDownloaderInterface
    {
        /**
         * Reverse the order of the downloaders so that the ones added last are checked first.
         * @var BinaryDownloaderInterface[] $downloaders
         */
        $downloaders = array_reverse($this->downloaders);
        foreach ($downloaders as $downloader) {
            if ($downloader->checkEligibility()) {
                return $downloader;
            }
        }

        throw new NoDownloaderFoundException('No eligible downloader found for Mock Server binaries.');
    }
}
