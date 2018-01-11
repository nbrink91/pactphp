<?php

/*
 * This file is part of Pact for PHP.
 * (c) Mattersight Corporation
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pact\Core\Matcher;

/**
 * Generate matching rules from a request or response body.
 * Class MatchParser
 */
class MatchParser
{
    /** @var MatcherInterface */
    private $matchingRules;

    /**
     * Generate matching rules from a request or response body.
     *
     * @param $body
     * @param string $jsonPath
     *
     * @return mixed
     */
    public function matchParser(&$body, string $jsonPath = '$.body')
    {
        if (\is_iterable($body)) {
            foreach ($body as $key => &$item) {
                if ($item instanceof MatcherInterface) {
                    $path = "{$jsonPath}.{$key}";

                    if (\is_array($item->getValue())) {
                        $path .= '[*]';
                    }

                    $this->addMatchingRule($path, $item);
                    $item = $item->getValue();
                } elseif (\is_iterable($item)) {
                    $this->matchParser($item, $jsonPath);
                }
            }
        }

        return $this->matchingRules;
    }

    private function addMatchingRule(string $path, MatcherInterface $matchingRule): self
    {
        $this->matchingRules[$path] = $matchingRule;

        return $this;
    }
}
