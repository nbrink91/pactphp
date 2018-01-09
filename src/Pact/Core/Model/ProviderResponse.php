<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Model;

/**
 * Response expectation that would be in response to a Consumer request from the Provider.
 * Class ProviderResponse
 */
class ProviderResponse
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string[]
     */
    private $headers;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return ProviderResponse
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

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
     * @return ProviderResponse
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
     * @return ProviderResponse
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
     * @return ProviderResponse
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }
}
