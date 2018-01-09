<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer;

class MockServerEnvConfig extends MockServerConfig
{
    public function __construct()
    {
        parent::__construct(
            \getenv('PACT_MOCK_SERVER_HOST'),
            \getenv('PACT_MOCK_SERVER_PORT'),
            \getenv('PACT_CONSUMER_NAME'),
            \getenv('PACT_PROVIDER_NAME')
        );
    }
}
