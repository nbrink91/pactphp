<?php

namespace Pact\Consumer;

/**
 * Configuration defining the default Pact Ruby Standalone server.
 * Class MockServerConfig
 * @package Pact\Consumer
 */
class MockServerConfig
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int;
     */
    private $port;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return MockServerConfig
     */
    public function setHost(string $host): MockServerConfig
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return MockServerConfig
     */
    public function setPort(int $port): MockServerConfig
    {
        $this->port = $port;
        return $this;
    }
}
