<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\BinaryManager\Exception;

use Exception;

/**
 * File failed to download from external source.
 * Class FileDownloadFailureException
 */
class FileDownloadFailureException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
