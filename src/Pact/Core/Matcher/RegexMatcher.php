<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Matcher;

class RegexMatcher implements MatcherInterface
{
    /** @var mixed */
    private $value;

    /** @var string */
    private $regex;

    public function __construct($value, $regex)
    {
        $this->value = $value;
        $this->regex = $regex;
    }

    /** @inheritdoc */
    public function getMatch(): string
    {
        return 'regex';
    }

    /** @inheritdoc */
    public function getValue()
    {
        return $this->value;
    }

    /** @inheritdoc */
    public function jsonSerialize()
    {
        return [
            'match' => $this->getMatch(),
            'regex' => $this->regex
        ];
    }
}
