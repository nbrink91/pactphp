<?php

namespace Pact\Consumer;

use Pact\Consumer\Service\RubyStandaloneBinaryManager;
use PHPUnit\Framework\TestCase;


class MockServerTest extends TestCase
{
    public function testStartAndStop()
    {
        try {
            $binaryManager = new RubyStandaloneBinaryManager(sys_get_temp_dir());
            $config = new MockServerConfig('localhost', 7200, 'someConsumer', 'someProvider', sys_get_temp_dir());
            $mockServer = new MockServer($config, $binaryManager);
            $pid = $mockServer->start();
            $this->assertTrue(is_int($pid));
        } finally {
            $result = $mockServer->stop();
            $this->assertTrue($result);
        }
    }
}
