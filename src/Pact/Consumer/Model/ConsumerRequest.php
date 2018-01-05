<?php

namespace Pact\Consumer\Model;

class ConsumerRequest
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string[]
     */
    private $headers = [];

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return ConsumerRequest
     */
    public function setMethod(string $method): ConsumerRequest
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return ConsumerRequest
     */
    public function setPath(string $path): ConsumerRequest
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string[] $headers
     * @return ConsumerRequest
     */
    public function setHeaders(array $headers): ConsumerRequest
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     * @return ConsumerRequest
     */
    public function addHeader(string $header, string $value): ConsumerRequest
    {
        $this->headers[$header] = $value;
        return $this;
    }
}