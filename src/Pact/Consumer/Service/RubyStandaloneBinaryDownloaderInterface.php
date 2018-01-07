<?php

namespace Pact\Consumer\Service;

use Pact\Consumer\Model\RubyStandaloneBinaryScripts;

/**
 * Interface RubyStandaloneBinaryDownloaderInterface
 * @package Pact\Consumer\Service
 */
interface RubyStandaloneBinaryDownloaderInterface
{
    /**
     * @return bool
     */
    public function checkEligibility(): bool;

    /**
     * Download the file and install it in the necessary directory.
     * @param string $destinationDir Folder path to put the binaries.
     * @return RubyStandaloneBinaryScripts
     */
    public function install(string $destinationDir): RubyStandaloneBinaryScripts;
}
