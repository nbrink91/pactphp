<?php

namespace Pact\Consumer\Model;

/**
 * Request/Response Pair to be posted to the Ruby Standalone Mock Server for PACT tests.
 * Class Interaction
 * @package Pact\Consumer\Model
 */
class Interaction
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $providerState;

    /**
     * @var ConsumerRequest
     */
    private $request;

    /**
     * @var ProviderResponse
     */
    private $response;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Interaction
     */
    public function setDescription(string $description): Interaction
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getProviderState(): string
    {
        return $this->providerState;
    }

    /**
     * @param string $providerState
     * @return Interaction
     */
    public function setProviderState(string $providerState): Interaction
    {
        $this->providerState = $providerState;
        return $this;
    }

    /**
     * @return ConsumerRequest
     */
    public function getRequest(): ConsumerRequest
    {
        return $this->request;
    }

    /**
     * @param ConsumerRequest $request
     * @return Interaction
     */
    public function setRequest(ConsumerRequest $request): Interaction
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ProviderResponse
     */
    public function getResponse(): ProviderResponse
    {
        return $this->response;
    }

    /**
     * @param ProviderResponse $response
     * @return Interaction
     */
    public function setResponse(ProviderResponse $response): Interaction
    {
        $this->response = $response;
        return $this;
    }
}