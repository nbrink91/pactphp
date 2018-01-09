<?php

namespace Pact\Core\BinaryManager\Model;

/**
 * Represents locations of Ruby Standalone full path and scripts.
 * Class BinaryScripts
 * @package Pact\Core\BinaryManager\Model
 */
class BinaryScripts
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
