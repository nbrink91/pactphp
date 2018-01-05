<?php

namespace Pact\Consumer;

use Pact\Consumer\Model\ConsumerRequest;
use Pact\Consumer\Model\ProviderResponse;

interface InteractionBuilderInterface
{
    public function given(string $description): InteractionBuilder;
    public function uponReceiving(string $providerState): InteractionBuilder;
    public function with(ConsumerRequest $request): InteractionBuilder;
    public function willRespondWith(ProviderResponse $response): InteractionBuilder;
    public function buildJson(): string;
}
