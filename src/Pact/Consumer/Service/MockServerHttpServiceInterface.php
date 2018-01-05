<?php

namespace Pact\Consumer\Service;

use Pact\Consumer\Model\Interaction;

/**
 * Interface MockServerHttpServiceInterface
 * @package Pact\Consumer\Service
 */
interface MockServerHttpServiceInterface
{
    /**
     * Create a single interaction.
     * @param Interaction $interaction
     * @return string
     */
    public function createInteraction(Interaction $interaction): string;
}