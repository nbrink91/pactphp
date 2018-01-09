<?php

namespace Pact\Consumer;

use Pact\Core\BinaryManager\BinaryManager;
use PHPUnit\Framework\TestCase;

class MockServerTest extends TestCase
{
    public function testStartAndStop()
    {
        try {
            $mockServer = new MockServer(new MockServerEnvConfig(), new BinaryManager());
            $pid = $mockServer->start();
            $this->assertTrue(is_int($pid));
        } finally {
            $result = $mockServer->stop();
            $this->assertTrue($result);
        }
    }
}
