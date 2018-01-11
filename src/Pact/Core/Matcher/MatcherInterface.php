<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Matcher;

interface MatcherInterface extends \JsonSerializable
{
    public function getMatch(): string;

    public function getValue();
}
