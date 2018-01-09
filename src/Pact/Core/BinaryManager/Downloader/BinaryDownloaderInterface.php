<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\BinaryManager\Downloader;

use Pact\Core\BinaryManager\Model\BinaryScripts;

/**
 * Interface BinaryDownloaderInterface
 */
interface BinaryDownloaderInterface
{
    /**
     * Verify if the downloader works for the current environment.
     *
     * @return bool
     */
    public function checkEligibility(): bool;

    /**
     * Download the file and install it in the necessary directory.
     *
     * @param string $destinationDir folder path to put the binaries
     *
     * @return BinaryScripts
     */
    public function install(string $destinationDir): BinaryScripts;
}
