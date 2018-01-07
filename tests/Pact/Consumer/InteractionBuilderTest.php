<?php

namespace Pact\Consumer;

use Pact\Consumer\Model\ConsumerRequest;
use Pact\Consumer\Model\ProviderResponse;
use PHPUnit\Framework\TestCase;

class InteractionBuilderTest extends TestCase
{
    public function testSend()
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

        $config = new MockServerConfig('localhost', 7200);
        $builder = new InteractionBuilder($config);
        $result = $builder
            ->given("A test request.")
            ->uponReceiving("A test response.")
            ->with($request)
            ->willRespondWith($response);

        $this->assertEquals('Registered interactions', $result);
    }
}
