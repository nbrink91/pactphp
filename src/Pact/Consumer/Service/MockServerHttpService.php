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
     * @inheritdoc
     */
    public function healthcheck(): bool
    {
        $uri = $this->config->getBaseUri()->withPath('/');
        $response = $this->client->get($uri, [
            'headers' => [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteAllInteractions(): bool
    {
        $uri = $this->config->getBaseUri()->withPath('/interactions');

        $response = $this->client->delete($uri, [
            'headers' => [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function createInteraction(Interaction $interaction): bool
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

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function verifyInteractions(): bool
    {
        $uri = $this->config->getBaseUri()->withPath('/interactions/verification');

        $response = $this->client->get($uri, [
            'headers' => [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getPactJson(): string
    {
        $uri = $this->config->getBaseUri()->withPath('/pact');
        $response = $this->client->post($uri, [
            'headers' => [
                "Content-Type" => "application/json",
                "X-Pact-Mock-Service" => true
            ]
        ]);

        return json_encode(json_decode($response->getBody()->getContents()));
    }
}
