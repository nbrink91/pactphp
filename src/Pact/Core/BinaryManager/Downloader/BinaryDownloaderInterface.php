<?php

namespace Pact\Core\BinaryManager\Downloader;

use Pact\Core\BinaryManager\Model\BinaryScripts;

/**
 * Interface BinaryDownloaderInterface
 * @package Pact\BinaryManager\Downloader
 */
interface BinaryDownloaderInterface
{
    /**
     * Verify if the downloader works for the current environment.
     * @return bool
     */
    public function checkEligibility(): bool;

    /**
     * Download the file and install it in the necessary directory.
     * @param string $destinationDir Folder path to put the binaries.
     * @return BinaryScripts
     */
    public function install(string $destinationDir): BinaryScripts;
}
