<?php

namespace PhpPact\Core\Broker\Service;

use PhpPact\Core\Http\ClientInterface;
use Psr\Http\Message\UriInterface;

class HttpService implements HttpServiceInterface
{
    /** @var ClientInterface */
    private $httpClient;

    /** @var UriInterface */
    private $baseUri;

    /**
     * @inheritdoc
     */
    public function __construct(ClientInterface $httpClient, UriInterface $baseUri)
    {
        $this->httpClient = $httpClient;
        $this->baseUri    = $baseUri;
    }

    /**
     * @inheritDoc
     */
    public function publishJson(string $json, string $version)
    {
        $array    = \json_decode($json, true);
        $consumer = $array['consumer']['name'];
        $provider = $array['provider']['name'];

        /** @var UriInterface $uri */
        $uri = $this->baseUri->withPath("pacts/provider/{$provider}/consumer/{$consumer}/version/{$version}");

        $this->httpClient->put($uri, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => $json
        ]);
    }
}
