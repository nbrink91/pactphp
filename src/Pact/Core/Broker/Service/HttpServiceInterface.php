<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Broker\Service;

use Pact\Core\Http\ClientInterface;
use Psr\Http\Message\UriInterface;

/**
 * Interface for http interaction with the PACT Broker.
 * Interface HttpServiceInterface
 */
interface HttpServiceInterface
{
    /**
     * HttpServiceInterface constructor.
     *
     * @param ClientInterface $client  Http Client
     * @param UriInterface    $baseUri Base URI for the Pact Broker
     */
    public function __construct(ClientInterface $client, UriInterface $baseUri);

    /**
     * Publish JSON
     *
     * @param string $version Consumer version
     * @param string $json    PACT File JSON
     */
    public function publishJson(string $version, string $json);
}
