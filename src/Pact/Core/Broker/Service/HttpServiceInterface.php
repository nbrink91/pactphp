<?php

namespace Pact\Core\Broker\Service;

use Pact\Core\Http\ClientInterface;
use Psr\Http\Message\UriInterface;

/**
 * Interface for http interaction with the PACT Broker.
 * Interface HttpServiceInterface
 * @package Pact\Core\Broker\Service
 */
interface HttpServiceInterface
{
    /**
     * HttpServiceInterface constructor.
     * @param ClientInterface $client Http Client
     * @param UriInterface $baseUri Base URI for the Pact Broker
     */
    public function __construct(ClientInterface $client, UriInterface $baseUri);

    /**
     * Publish JSON
     * @param string $version Consumer version
     * @param string $json PACT File JSON
     * @return bool
     */
    public function publishJson(string $version, string $json): bool;
}
