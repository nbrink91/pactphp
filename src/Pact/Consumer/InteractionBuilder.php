<?php

namespace Pact\Consumer;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use Pact\Consumer\Model\ConsumerRequest;
use Pact\Consumer\Model\Interaction;
use Pact\Consumer\Model\ProviderResponse;

class InteractionBuilder implements InteractionBuilderInterface
{
    /** @var Interaction */
    private $interaction;

    public function __construct()
    {
        $this->interaction = new Interaction();
    }

    public function given(string $description): InteractionBuilder
    {
        $this->interaction->setDescription($description);
        return $this;
    }

    public function uponReceiving(string $providerState): InteractionBuilder
    {
        $this->interaction->setProviderState($providerState);
        return $this;
    }

    public function with(ConsumerRequest $request): InteractionBuilder
    {
        $this->interaction->setRequest($request);
        return $this;
    }

    public function willRespondWith(ProviderResponse $response): InteractionBuilder
    {
        $this->interaction->setResponse($response);
        return $this;
    }

    public function buildJson(): string
    {
        $serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
        return $serializer->serialize($this->interaction, 'json');
    }

    public function send(MockServerConfig $config)
    {
        $request = new Request(
            "POST",
            "http://{$config->getHost()}:{$config->getPort()}/interactions",
            [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ],
            $this->buildJson()
        );

        $client = new Client();
        $client->send($request);
    }
}
