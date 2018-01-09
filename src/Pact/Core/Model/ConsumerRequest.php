<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Model;

/**
 * Request initiated by the consumer.
 * Class ConsumerRequest
 */
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
    private $headers;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @var string
     */
    private $query;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return ConsumerRequest
     */
    public function setMethod(string $method): self
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
     *
     * @return ConsumerRequest
     */
    public function setPath(string $path): self
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
     *
     * @return ConsumerRequest
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     *
     * @return ConsumerRequest
     */
    public function addHeader(string $header, string $value): self
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     *
     * @return ConsumerRequest
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     *
     * @return ConsumerRequest
     */
    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return ConsumerRequest
     */
    public function addQueryParameter(string $key, string $value): self
    {
        if ($this->query === null) {
            $this->query = "{$key}={$value}";
        } else {
            $this->query = "{$this->query}&{$key}={$value}";
        }

        return $this;
    }
}
