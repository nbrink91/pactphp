<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer;

use Pact\Consumer\Service\MockServerHttpService;
use Pact\Consumer\Service\MockServerHttpServiceInterface;
use Pact\Core\BinaryManager\BinaryManager;
use Pact\Core\Http\GuzzleClient;
use Pact\Core\Model\ConsumerRequest;
use Pact\Core\Model\ProviderResponse;
use PHPUnit\Framework\TestCase;

class InteractionBuilderTest extends TestCase
{
    /** @var MockServerHttpServiceInterface */
    private $service;

    /** @var MockServer */
    private $mockServer;

    protected function setUp(): void
    {
        $config           = new MockServerConfig('localhost', '7200', 'someConsumer', 'someProvider');
        $binaryManager    = new BinaryManager(\sys_get_temp_dir());
        $this->mockServer = new MockServer($config, $binaryManager);
        $this->mockServer->start();
        $this->service = new MockServerHttpService(new GuzzleClient(), $config);
    }

    protected function tearDown(): void
    {
        $this->mockServer->stop();
    }

    public function testSimpleGet(): void
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
                'message' => 'Hello, world!'
            ])
            ->addHeader('Content-Type', 'application/json');

        $builder = new InteractionBuilder(new MockServerEnvConfig());
        $result  = $builder
            ->given('A test request.')
            ->uponReceiving('A test response.')
            ->with($request)
            ->willRespondWith($response);

        $this->assertTrue($result);
    }

    public function testPostWithBody(): void
    {
        $request = new ConsumerRequest();
        $request
            ->setPath('/something')
            ->setMethod('GET')
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'someStuff'  => 'someOtherStuff',
                'someNumber' => 12,
                'anArray'    => [
                    12,
                    'words here',
                    493.5
                ]
            ]);

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => 'Hello, world!'
            ]);

        $builder = new InteractionBuilder(new MockServerEnvConfig());
        $result  = $builder
            ->given('A test request.')
            ->uponReceiving('A test response.')
            ->with($request)
            ->willRespondWith($response);

        $this->assertTrue($result);
    }
}
