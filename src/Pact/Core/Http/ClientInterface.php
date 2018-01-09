<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Client Interface
 * Interface ClientInterface
 */
interface ClientInterface
{
    /**
     * Get Request
     *
     * @param UriInterface $uri
     * @param array        $options
     *
     * @return ResponseInterface
     */
    public function get(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Put Request
     *
     * @param UriInterface $uri
     * @param array        $options
     *
     * @return ResponseInterface
     */
    public function put(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Post Request
     *
     * @param UriInterface $uri
     * @param array        $options
     *
     * @return ResponseInterface
     */
    public function post(UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * Delete Request
     *
     * @param UriInterface $uri
     * @param array        $options
     *
     * @return ResponseInterface
     */
    public function delete(UriInterface $uri, array $options = []): ResponseInterface;
}
