# Pact for PHP

## What is PACT?
Pact is a consumer driver testing framework. See [PACT](pact.io) for more information.

## Installation

Install using composer

```bash
composer require mattersight/pact --dev
```

## Components

### Listener
PHPUnit supports [listeners](https://phpunit.de/manual/current/en/appendixes.configuration.html#appendixes.configuration.test-listeners) to hook events that are used while testing. The listener is needed to start and stop the [mock server](https://github.com/pact-foundation/pact-mock_service) that is going to be used to make HTTP requests for the consumer.

This can be extended or a new customer listener created and used. The default listener uses an environmental variable configuration that can be set in your [phpunit.xml](#Usage).

### Interaction Builder

In each test you will need to build an Interaction. This is what defines what a request/response pair is.

This builder will require you to make both the expected request and expected response.

The `willRespondWith()` function will need to be called last because it is what sends the interaction to the mock server.

Once the interaction is set, you can use your http service to make the actual request. This should return the data you configured in the interaction builder. This is when you can make assertions against the http service responses.

Class | Use
--- | ---
Pact\Core\Model\ConsumerRequest | Build the expected consumer request to pass into the interaction builder.
Pact\Core\Model\ProviderResponse | Build the expected providers response to pass into the interaction builder.
Pact\Consumer\InteractionBuilder | Build the actual interaction that will require both the request and response. This requires a MockServerConfigInterface implementation due to the need to know where the server is located.

### Matchers

Currently these are only compatible with version 2.0+ of the [Pact Specification](https://github.com/pact-foundation/pact-specification).

Class | Parameters
--- | ---


## Usage

0. Update your phpunit.xml configuration by adding the following.

    ```xml
    <phpunit>
         <testsuites>
             <testsuite name="ConsumerTests">
                 <directory>./tests/Consumer</directory>
             </testsuite>
         </testsuites>
        <listeners>
            <listener class="Pact\Consumer\PactTestListener">
                <arguments>
                    <array>
                        <element>
                            <string>ConsumerTests</string>
                        </element>
                    </array>
                </arguments>
            </listener>
        </listeners>
        <php>
            <env name="PACT_MOCK_SERVER_HOST" value="localhost"/>
            <env name="PACT_MOCK_SERVER_PORT" value="7200"/>
            <env name="PACT_CONSUMER_NAME" value="someConsumer"/>
            <env name="PACT_PROVIDER_NAME" value="someProvider"/>
            <env name="PACT_BROKER_URI" value="http://localhost"/>
            <env name="PACT_CONSUMER_VERSION" value="1.0.0"/>
        </php>
     </phpunit>
    ```
    
    * The test suite name must match the test suite name being injected into the listener arguments.
    
    * The default listener uses a configuration based on environmental variables. In the 'php' section of the config, you will see the 6 environmental variables.
    
    * Each Consumer and Provider combination will need to be its own Test Suite.

0. Create a http service for the Provider that your application will be interacting with.

    ```php
   <?php
    
    // src/Consumer/Service/HttpService.php
    
    namespace Consumer\Service;
    
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Uri;
    
     /**
     * Http Service to interact with example provider
     */
    class ConsumerService
    {
        /** @var Client */
        private $httpClient;
    
        /** @var string */
        private $baseUri;
    
        public function __construct(string $baseUri)
        {
            $this->httpClient = new Client();
            $this->baseUri    = $baseUri;
        }
    
        public function getHelloString(string $name): string
        {
            $response = $this->httpClient->request('GET', new Uri("{$this->baseUri}/hello/{$name}"), [
                'headers' => ['Content-Type' => 'application/json']
            ]);
            $body   = $response->getBody();
            $object = \json_decode($body);
    
            return $object->message;
        }
    
        public function getGoodbyeString(string $name): string
        {
            $response = $this->httpClient->request('GET', "{$this->baseUri}/goodbye/{$name}", [
                'headers' => ['Content-Type' => 'application/json']
            ]);
            $body   = $response->getBody();
            $object = \json_decode($body);
    
            return $object->message;
        }
    }
    ```
    
    You can interact with the API using whatever library you would like including [Guzzle](https://github.com/guzzle/guzzle).

0. Create your first test.

    ```php
   <?php
    
    Php   Pact            
    
    namespace Consumer\Service;
    
    use Pact\Consumer\InteractionBuilder;
    use Pact\Consumer\MockServerEnvConfig;
    use Pact\Core\Model\ConsumerRequest;
    use Pact\Core\Model\ProviderResponse;
    use PHPUnit\Framework\TestCase;
    
    class ConsumerServiceHelloTest extends TestCase
    {
        public function testGetHelloString()
        {
            $request = new ConsumerRequest();
            $request
                ->setMethod('GET')
                ->setPath('/hello/Nick')
                ->addHeader('Content-Type', 'application/json');
    
            $response = new ProviderResponse();
            $response
                ->setStatus(200)
                ->addHeader('Content-Type', 'application/json')
                ->setBody([
                    'message' => new RegexMatcher('Hello, Nick', '(Hello, ).*')
                ]);
    
            $config      = new MockServerEnvConfig();
            $mockService = new InteractionBuilder($config);
            $mockService
                ->given('Get Hello')
                ->uponReceiving('A get request to /hello/{name}')
                ->with($request)
                ->willRespondWith($response);
    
            $service = new HttpService($config->getBaseUri());
            $result  = $service->getHelloString('Nick');
    
            $this->assertEquals('Hello, Nick', $result);
        }
   }
    ```