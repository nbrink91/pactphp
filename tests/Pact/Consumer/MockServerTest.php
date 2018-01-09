<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer;

use Pact\Core\BinaryManager\BinaryManager;
use PHPUnit\Framework\TestCase;

class MockServerTest extends TestCase
{
    public function testStartAndStop(): void
    {
        try {
            $mockServer = new MockServer(new MockServerEnvConfig(), new BinaryManager());
            $pid        = $mockServer->start();
            $this->assertTrue(\is_int($pid));
        } finally {
            $result = $mockServer->stop();
            $this->assertTrue($result);
        }
    }
}
