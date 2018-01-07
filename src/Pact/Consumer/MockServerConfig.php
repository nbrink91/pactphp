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
     * Host on which to bind the service
     * @var string
     */
    private $host = 'localhost';

    /**
     * Port on which to run the service
     * @var int
     */
    private $port = 7200;

    /**
     * @var bool
     */
    private $secure = false;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * Consumer name
     * @var string
     */
    private $consumer;

    /**
     * Provider name
     * @var string
     */
    private $provider;

    /**
     * Directory to which the pacts will be written
     * @var string
     */
    private $pactDir;

    /**
     * `overwrite` or `merge`. Use `merge` when running multiple mock service
     * instances in parallel for the same consumer/provider pair. Ensure the
     * pact file is deleted before running tests when using this option so that
     * interactions deleted from the code are not maintained in the file.
     * @var string
     */
    private $pactFileWriteMode = 'overwrite';

    /**
     * The pact specification version to use when writing the pact. Note that only versions 1 and 2 are currently supported.
     * @var float
     */
    private $pactSpecificationVersion;

    /**
     * File to which to log output
     * @var string
     */
    private $log;

    public function __construct(string $host, int $port, string $consumer, string $provider, string $pactDir)
    {
        $this->host = $host;
        $this->port = $port;
        $this->consumer = $consumer;
        $this->provider = $provider;
        $this->pactDir = $pactDir;
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

    /**
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     * @return MockServerConfig
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     * @return MockServerConfig
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsumer(): string
    {
        return $this->consumer;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getPactDir(): ?string
    {
        return $this->pactDir;
    }

    /**
     * @return string
     */
    public function getPactFileWriteMode(): string
    {
        return $this->pactFileWriteMode;
    }

    /**
     * @param string $pactFileWriteMode
     * @return MockServerConfig
     */
    public function setPactFileWriteMode(string $pactFileWriteMode): MockServerConfig
    {
        $options = ['overwrite', 'merge'];

        if (!in_array($pactFileWriteMode, $options)) {
            $implodedOptions = implode(',', $options);
            throw new \InvalidArgumentException("Invalid Pact File Write Mode, value must be one of the following: {$implodedOptions}");
        }

        $this->pactFileWriteMode = $pactFileWriteMode;
        return $this;
    }

    /**
     * @return float
     */
    public function getPactSpecificationVersion(): ?float
    {
        return $this->pactSpecificationVersion;
    }

    /**
     * @param float $pactSpecificationVersion
     * @return MockServerConfig
     */
    public function setPactSpecificationVersion(float $pactSpecificationVersion): MockServerConfig
    {
        $this->pactSpecificationVersion = $pactSpecificationVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getLog(): ?string
    {
        return $this->log;
    }

    /**
     * @param string $log
     * @return MockServerConfig
     */
    public function setLog(string $log): MockServerConfig
    {
        $this->log = $log;
        return $this;
    }
}
