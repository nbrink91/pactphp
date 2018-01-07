<?php

namespace Pact\Consumer\Model;

/**
 * Represents locations of Ruby Standalone full path and scripts.
 * Class RubyStandaloneBinaryScripts
 * @package Pact\Consumer\Model
 */
class RubyStandaloneBinaryScripts
{
    /**
     * Path to Pact Mock Service
     * @var string
     */
    private $mockService;

    public function __construct(string $mockService)
    {
        $this->mockService = $mockService;
    }

    /**
     * @return string
     */
    public function getMockService(): string
    {
        return $this->mockService;
    }
}