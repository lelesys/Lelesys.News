<?php
namespace Lelesys\News\Fusion\Eel\Helper;

/*
 * This file is part of the Lelesys.News package.
 *
 * (c) Lelesys
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\ProtectedContextAwareInterface;

/**
 * News helpers for Eel contexts
 */
class ConfigurationHelper implements ProtectedContextAwareInterface
{
    /**
     * @param array $configuration Source configuration
     * @param NodeInterface $node Node properties to read from
     * @return array
     * @throws \Neos\ContentRepository\Exception\NodeException
     */
    public function mergeWithNodeProperties(array $configuration, NodeInterface $node)
    {
        foreach ($configuration as $key => $value) {
            if (is_array($value)) {
                $configuration[$key] = $this->mergeWithNodeProperties($value, $node);
            } else {
                if ($node->hasProperty($key)) {
                    $propertyValue = $node->getProperty($key);
                    if (!empty($propertyValue)) {
                        $configuration[$key] = $propertyValue;
                    }
                }
            }
        }

        return $configuration;
    }

    /**
     * All methods are considered safe
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
