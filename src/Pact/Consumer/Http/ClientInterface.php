<?php

namespace Pact\Consumer\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Client Interface
 * Interface ClientInterface
 * @package Pact\Consumer\Http
 */
interface ClientInterface
{
    /**
     * Get Request
     * @param UriInterface $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function get(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Put Request
     * @param UriInterface $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function put(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Post Request
     * @param UriInterface $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function post(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Delete Request
     * @param UriInterface $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function delete(UriInterface $uri, array $options = []): ResponseInterface;

}
