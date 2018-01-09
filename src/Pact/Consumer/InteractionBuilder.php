<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer;

use Pact\Consumer\Service\MockServerHttpService;
use Pact\Core\Http\GuzzleClient;
use Pact\Core\Model\ConsumerRequest;
use Pact\Core\Model\Interaction;
use Pact\Core\Model\ProviderResponse;

/**
 * Build an interaction and send it to the Ruby Standalone Mock Service
 * Class InteractionBuilder
 */
class InteractionBuilder implements InteractionBuilderInterface
{
    /** @var Interaction */
    private $interaction;

    /** @var MockServerConfig */
    private $config;

    /**
     * InteractionBuilder constructor.
     *
     * @param MockServerConfigInterface $config
     */
    public function __construct(MockServerConfigInterface $config)
    {
        $this->interaction = new Interaction();
        $this->config      = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function given(string $description): InteractionBuilderInterface
    {
        $this->interaction->setDescription($description);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function uponReceiving(string $providerState): InteractionBuilderInterface
    {
        $this->interaction->setProviderState($providerState);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function with(ConsumerRequest $request): InteractionBuilderInterface
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
