<?php

namespace Pact\Core\BinaryManager\Exception;

use Exception;

/**
 * Unable to find a downloader to get the binaries.
 * Class NoDownloaderFoundException
 * @package Pact\Core\BinaryManager\Exception
 */
class NoDownloaderFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
