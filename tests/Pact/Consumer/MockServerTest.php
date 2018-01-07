<?php

namespace Pact\Consumer;

use PHPUnit\Framework\TestCase;

class MockServerTest extends TestCase
{
    public function testStart()
    {
        try {
            $config = new MockServerConfig('localhost', 7200, 'someConsumer', 'someProvider', sys_get_temp_dir());
            $mockServer = new MockServer($config);
            $pid = $mockServer->start();
            $this->assertTrue(is_int($pid));
        } finally {
            $result = $mockServer->stop();
            $this->assertTrue($result);
        }
    }
}
