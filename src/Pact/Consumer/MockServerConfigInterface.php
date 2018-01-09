<?php

namespace Pact\Consumer;

use Psr\Http\Message\UriInterface;

interface MockServerConfigInterface
{
    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return int
     */
    public function getPort(): int;

    /**
     * @return bool
     */
    public function isSecure(): bool;

    /**
     * @return UriInterface
     */
    public function getBaseUri(): UriInterface;

    /**
     * @return string
     */
    public function getConsumer(): string;

    /**
     * @return string
     */
    public function getProvider(): string;

    /**
     * @return string
     */
    public function getPactDir(): ?string;

    /**
     * @param string $pactDir
     * @return MockServerConfigInterface
     */
    public function setPactDir(string $pactDir): MockServerConfigInterface;

    /**
     * @return string
     */
    public function getPactFileWriteMode(): string;

    /**
     * @param string $pactFileWriteMode
     * @return MockServerConfigInterface
     */
    public function setPactFileWriteMode(string $pactFileWriteMode): MockServerConfigInterface;

    /**
     * @return float
     */
    public function getPactSpecificationVersion(): ?float;

    /**
     * @param float $pactSpecificationVersion
     * @return MockServerConfigInterface
     */
    public function setPactSpecificationVersion(float $pactSpecificationVersion): MockServerConfigInterface;

    /**
     * @return string
     */
    public function getLog(): ?string;

    /**
     * @param string $log
     * @return MockServerConfigInterface
     */
    public function setLog(string $log): MockServerConfigInterface;
}
