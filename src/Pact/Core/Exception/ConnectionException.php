<?php

namespace Pact\Core\Exception;

use Exception;

/**
 * Unable to connect to server.
 * Class ConnectionException
 * @package Pact\Core\Exception
 */
class ConnectionException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
