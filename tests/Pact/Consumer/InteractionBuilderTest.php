<?php

namespace Pact\Consumer;

use Pact\Consumer\Http\GuzzleClient;
use Pact\Consumer\Model\ConsumerRequest;
use Pact\Consumer\Model\ProviderResponse;
use Pact\Consumer\Service\MockServerHttpService;
use Pact\Consumer\Service\MockServerHttpServiceInterface;
use Pact\Consumer\Service\RubyStandaloneBinaryManager;
use PHPUnit\Framework\TestCase;

class InteractionBuilderTest extends TestCase
{
    /** @var MockServerHttpServiceInterface */
    private $service;

    /** @var MockServer */
    private $mockServer;

    protected function setUp()
    {
        $config = new MockServerConfig('localhost', '7200', 'someConsumer', 'someProvider', sys_get_temp_dir());
        $binaryManager = new RubyStandaloneBinaryManager(sys_get_temp_dir());
        $this->mockServer = new MockServer($config, $binaryManager);
        $this->mockServer->start();
        $this->service = new MockServerHttpService(new GuzzleClient(), $config);
    }

    protected function tearDown()
    {
        $this->mockServer->stop();
    }

    public function testWillRespondWith()
    {
        $request = new ConsumerRequest();
        $request
            ->setPath('/something')
            ->setMethod('GET')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->setBody([
                "message" => "Hello, world!"
            ])
            ->addHeader('Content-Type', 'application/json');

        $config = new MockServerConfig('localhost', 7200, 'someConsumer', 'someProvider', sys_get_temp_dir());
        $builder = new InteractionBuilder($config);
        $result = $builder
            ->given("A test request.")
            ->uponReceiving("A test response.")
            ->with($request)
            ->willRespondWith($response);

        $this->assertTrue($result);
    }
}
