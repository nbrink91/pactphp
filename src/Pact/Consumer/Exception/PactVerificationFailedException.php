<?php

namespace Pact\Consumer\Exception;

use Exception;

/**
 * Failed to verify that all PACT interactions were tested.
 * Class PactVerificationFailedException
 * @package Pact\Consumer\Exception
 */
class PactVerificationFailedException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
