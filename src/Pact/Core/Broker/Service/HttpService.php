<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Broker\Service;

use Exception;
use Pact\Core\Http\ClientInterface;
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
    public function publishJson(string $json, string $version): bool
    {
        $array    = \json_decode($json);
        $consumer = $array['consumer'];
        $provider = $array['provider'];

        $uri = $this->baseUri
            ->withPath('/pacts/provider')
            ->withPath($provider)
            ->withPath('consumer')
            ->withPath($consumer)
            ->withPath('version')
            ->withPath($version);

        $response = $this->httpClient->put($uri, [
            'body' => $json
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Unable to push Pact JSON to Pact Broker.');
        }

        return true;
    }
}
