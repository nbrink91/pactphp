<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
 */
class BinaryManager
{
    /** @var BinaryDownloaderInterface[] */
    private $downloaders = [];

    /**
     * Destination directory for PACT folder.
     *
     * @var string
     */
    private $destinationDir;

    public function __construct()
    {
        $this->destinationDir = \sys_get_temp_dir();
        $this->downloaders[]  = new BinaryDownloaderWindows();
    }

    /**
     * Add a single downloader.
     *
     * @param BinaryDownloaderInterface $downloader
     *
     * @return BinaryManager
     */
    public function addDownloader(BinaryDownloaderInterface $downloader): self
    {
        $this->downloaders[] = $downloader;

        return $this;
    }

    /**
     * Overwrite default downloaders.
     *
     * @param array $downloaders
     *
     * @return BinaryManager
     */
    public function setDownloaders(array $downloaders): self
    {
        $this->downloaders = $downloaders;

        return $this;
    }

    /**
     * Install.
     *
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
    public function uninstall(): void
    {
        $fs = new Filesystem();
        $fs->remove($this->destinationDir . DIRECTORY_SEPARATOR . 'pact');
    }

    /**
     * Get the first downloader that meets the systems eligibility.
     *
     * @throws Exception
     *
     * @return BinaryDownloaderInterface
     */
    private function getDownloader(): BinaryDownloaderInterface
    {
        /**
         * Reverse the order of the downloaders so that the ones added last are checked first.
         *
         * @var BinaryDownloaderInterface[]
         */
        $downloaders = \array_reverse($this->downloaders);
        foreach ($downloaders as $downloader) {
            if ($downloader->checkEligibility()) {
                return $downloader;
            }
        }

        throw new NoDownloaderFoundException('No eligible downloader found for Mock Server binaries.');
    }
}
