<?php

namespace Pact\Consumer;

use Pact\Core\BinaryManager\BinaryManager;
use Pact\Core\Http\GuzzleClient;
use Pact\Consumer\Service\MockServerHttpService;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

/**
 * PACT listener that can be used with environment variables and easily attached to PHPUnit configuration.
 * Class PactTestListener
 * @package Pact\Consumer
 */
class PactTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /** @var MockServer */
    private $server;

    /**
     * Name of the test suite configured in your phpunit config.
     * @var string
     */
    private $testSuiteNames;

    /**
     * PactTestListener constructor.
     * @param string[] $testSuiteNames Test Suite names that need evaluated with the listener.
     */
    public function __construct(array $testSuiteNames)
    {
        $this->testSuiteNames = $testSuiteNames;
    }

    /**
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->testSuiteNames)) {
            $config = new MockServerConfig(
                getenv('PACT_MOCK_SERVER_HOST'),
                getenv('PACT_MOCK_SERVER_PORT'),
                getenv('PACT_CONSUMER_NAME'),
                getenv('PACT_PROVIDER_NAME')
            );

            $this->server = new MockServer($config, new BinaryManager());
            $this->server->start();
        }
    }

    /**
     * Publish JSON results to PACT Broker and stop the Mock Server.
     * @param TestSuite $suite
     * @throws \Exception
     */
    public function endTestSuite(TestSuite $suite)
    {
        if (in_array($suite->getName(), $this->testSuiteNames)) {
            $httpService = new MockServerHttpService(new GuzzleClient(), new MockServerEnvConfig());
            $success = $httpService->verifyInteractions();

            if ($success === false) {
                throw new \Exception("It failed!");
            }
            $httpService->getPactJson();
            $this->server->stop();

            /**$connector = new PactBrokerConnector(new PactUriOptions(getenv('PACT_BROKER_URI')));
            $success = $connector->publishJson($json, getenv('PACT_CONSUMER_VERSION'));

            if ($success === false) {
                throw new \Exception("Failed to upload Pact File to Broker.");
            } else {
                echo "Pact JSON file uploaded to PACT Broker successfully.";
            }*/
        }
    }
}
