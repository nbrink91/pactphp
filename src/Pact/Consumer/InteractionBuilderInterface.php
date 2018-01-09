<?php

namespace Pact\Consumer;

use Pact\Core\Model\ConsumerRequest;
use Pact\Core\Model\ProviderResponse;

/**
 * Interface InteractionBuilderInterface
 * @package Pact\Consumer
 */
interface InteractionBuilderInterface
{
    /**
     * @param string $description What is given to the request.
     * @return InteractionBuilder
     */
    public function given(string $description): InteractionBuilder;

    /**
     * @param string $providerState What is received when the request is made.
     * @return InteractionBuilder
     */
    public function uponReceiving(string $providerState): InteractionBuilder;

    /**
     * @param ConsumerRequest $request Mock of request sent.
     * @return InteractionBuilder
     */
    public function with(ConsumerRequest $request): InteractionBuilder;

    /**
     * Make the http request to the Mock Service to register the interaction.
     * @param ProviderResponse $response Mock of response received.
     * @return bool Returns true on success.
     */
    public function willRespondWith(ProviderResponse $response): bool;
}
