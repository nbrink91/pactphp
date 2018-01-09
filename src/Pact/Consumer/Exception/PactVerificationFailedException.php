<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer\Exception;

use Exception;

/**
 * Failed to verify that all PACT interactions were tested.
 * Class PactVerificationFailedException
 */
class PactVerificationFailedException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
