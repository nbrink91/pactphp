<?php

namespace PhpPact\Consumer;

use PhpPact\Core\BinaryManager\BinaryManager;
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
