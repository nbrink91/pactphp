<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Consumer;

use Pact\Core\Model\ConsumerRequest;
use Pact\Core\Model\ProviderResponse;

/**
 * Interface InteractionBuilderInterface
 */
interface InteractionBuilderInterface
{
    /**
     * @param string $description what is given to the request
     *
     * @return InteractionBuilderInterface
     */
    public function given(string $description): self;

    /**
     * @param string $providerState what is received when the request is made
     *
     * @return InteractionBuilderInterface
     */
    public function uponReceiving(string $providerState): self;

    /**
     * @param ConsumerRequest $request mock of request sent
     *
     * @return InteractionBuilderInterface
     */
    public function with(ConsumerRequest $request): self;

    /**
     * Make the http request to the Mock Service to register the interaction.
     *
     * @param ProviderResponse $response mock of response received
     *
     * @return bool returns true on success
     */
    public function willRespondWith(ProviderResponse $response): bool;
}
