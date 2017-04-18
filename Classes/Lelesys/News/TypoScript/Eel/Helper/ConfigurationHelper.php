<?php
namespace Lelesys\News\TypoScript\Eel\Helper;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;

/**
 * News helpers for Eel contexts
 */
class ConfigurationHelper implements ProtectedContextAwareInterface {

	/**
	 * @param array $configuration Source configuration
	 * @param NodeInterface $node Node properties to read from
	 * @return array
	 */
	public function mergeWithNodeProperties(array $configuration, NodeInterface $node) {
		foreach ($configuration as $key => $value) {
			if (is_array($value)) {
				$configuration[$key] = $this->mergeWithNodeProperties($value, $node);
			} else {
				if ($node->hasProperty($key)) {
					$propertyValue =  $node->getProperty($key);
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
	public function allowsCallOfMethod($methodName) {
		return TRUE;
	}

}