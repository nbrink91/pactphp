<?php

namespace Pact\Consumer\Model;


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
     * @return ProviderResponse
     */
    public function setStatus(int $status): ProviderResponse
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
     * @return ProviderResponse
     */
    public function setHeaders(array $headers): ProviderResponse
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     * @return ProviderResponse
     */
    public function addHeader(string $header, string $value): ProviderResponse
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
     * @return ProviderResponse
     */
    public function setBody($body): ProviderResponse
    {
        $this->body = $body;
        return $this;
    }
}
