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
 * Unable to find a downloader to get the binaries.
 * Class NoDownloaderFoundException
 */
class NoDownloaderFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
