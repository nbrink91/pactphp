<?php

namespace Pact\Consumer\Service;

use Pact\Consumer\Http\GuzzleClient;
use Pact\Consumer\MockServerConfig;
use Pact\Consumer\Model\ConsumerRequest;
use Pact\Consumer\Model\Interaction;
use Pact\Consumer\Model\ProviderResponse;
use PHPUnit\Framework\TestCase;

class MockServerHttpServiceTest extends TestCase
{
    /** @var MockServerHttpServiceInterface */
    private $service;

    protected function setUp()
    {
        $config = new MockServerConfig('localhost', '7200');
        $this->service = new MockServerHttpService(new GuzzleClient(), $config);
    }

    public function testHealthcheck()
    {
        $result = $this->service->healthcheck();
        $this->assertTrue($result);
    }

    public function testCreateInteraction()
    {
        $request = new ConsumerRequest();
        $request
            ->setPath('/example')
            ->setMethod("GET");
        $response = new ProviderResponse();

        $interaction = new Interaction();
        $interaction
            ->setDescription('Fake description')
            ->setProviderState('Fake provider state')
            ->setRequest($request)
            ->setResponse($response);

        $result = $this->service->createInteraction($interaction);

        $this->assertTrue($result);
    }

    public function testDeleteAllInteractions()
    {
        $result = $this->service->deleteAllInteractions();
        $this->assertTrue($result);
    }

    public function testVerifyInteractions()
    {
        $result = $this->service->verifyInteractions();
        $this->assertTrue($result);
    }

    public function testGetPactJson()
    {
        $result = $this->service->getPactJson();
        $this->assertEquals('{"consumer":{"name":"someConsumer"},"provider":{"name":"someProvider"},"interactions":[],"metadata":{"pactSpecification":{"version":"2.0.0"}}}', $result);
    }
}
