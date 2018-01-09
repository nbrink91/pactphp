<?php

namespace Pact\Consumer;

use Pact\Core\Http\GuzzleClient;
use Pact\Consumer\Service\MockServerHttpService;
use Pact\Core\Model\ConsumerRequest;
use Pact\Core\Model\Interaction;
use Pact\Core\Model\ProviderResponse;

/**
 * Build an interaction and send it to the Ruby Standalone Mock Service
 * Class InteractionBuilder
 * @package Pact\Consumer
 */
class InteractionBuilder implements InteractionBuilderInterface
{
    /** @var Interaction */
    private $interaction;

    /** @var MockServerConfig */
    private $config;

    /**
     * InteractionBuilder constructor.
     * @param MockServerConfigInterface $config
     */
    public function __construct(MockServerConfigInterface $config)
    {
        $this->interaction = new Interaction();
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function given(string $description): InteractionBuilder
    {
        $this->interaction->setDescription($description);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function uponReceiving(string $providerState): InteractionBuilder
    {
        $this->interaction->setProviderState($providerState);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function with(ConsumerRequest $request): InteractionBuilder
    {
        $this->interaction->setRequest($request);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function willRespondWith(ProviderResponse $response): bool
    {
        $this->interaction->setResponse($response);
        return $this->send();
    }

    /**
     * {@inheritdoc}
     */
    private function send(): bool
    {
        $service = new MockServerHttpService(new GuzzleClient(), $this->config);
        return $service->registerInteraction($this->interaction);
    }
}
