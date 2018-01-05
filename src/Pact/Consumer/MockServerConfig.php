<?php

namespace Pact\Consumer;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

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
     * @var bool
     */
    private $secure;

    public function __construct(string $host, int $port, bool $secure = false)
    {
        $this->host = $host;
        $this->port = $port;
        $this->secure = $secure;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isSecure(): bool
    {
        return $this->secure;
    }

    /**
     * @return UriInterface
     */
    public function getBaseUri(): UriInterface
    {
        $protocol = $this->secure ? 'https' : 'http';

        return new Uri("{$protocol}://{$this->getHost()}:{$this->getPort()}");
    }
}
