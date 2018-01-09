<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\BinaryManager\Model;

/**
 * Represents locations of Ruby Standalone full path and scripts.
 * Class BinaryScripts
 */
class BinaryScripts
{
    /**
     * Path to Pact Mock Service
     *
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
