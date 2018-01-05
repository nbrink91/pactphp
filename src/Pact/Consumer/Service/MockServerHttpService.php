<?php

namespace Pact\Consumer\Service;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Pact\Consumer\Http\ClientInterface;
use Pact\Consumer\MockServerConfig;
use Pact\Consumer\Model\Interaction;

/**
 * Http Service that interacts with the Ruby Standalone Mock Server
 * @see https://github.com/pact-foundation/pact-mock_service
 * Class MockServerHttpService
 * @package Pact\Consumer\Service
 */
class MockServerHttpService implements MockServerHttpServiceInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var MockServerConfig
     */
    private $config;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * MockServerHttpService constructor.
     * @param ClientInterface $client
     * @param MockServerConfig $config
     */
    public function __construct(ClientInterface $client, MockServerConfig $config)
    {
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();

        $this->client = $client;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function createInteraction(Interaction $interaction): string
    {
        $uri = $this->config->getBaseUri()->withPath('/interactions');

        $body = $this->serializer->serialize($interaction, 'json');

        $response = $this->client->post($uri, [
            'headers' => [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ],
            'body' => $body
        ]);

        return trim(preg_replace('/\s\s+/', '', $response->getBody()->getContents()));
    }
}