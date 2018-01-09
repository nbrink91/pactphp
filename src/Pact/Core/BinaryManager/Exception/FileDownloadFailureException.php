<?php

namespace Pact\Core\BinaryManager\Exception;

use Exception;

/**
 * File failed to download from external source.
 * Class FileDownloadFailureException
 * @package Pact\Core\BinaryManager\Exception
 */
class FileDownloadFailureException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
