<?php
namespace Lelesys\News\TypoScript\Eel\Helper;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Eel\ProtectedContextAwareInterface;
use TYPO3\TYPO3CR\Domain\Model\Node;
use TYPO3\Flow\Annotations as Flow;

/**
 * Filters news nodes collection
 */
class FilterHelper implements ProtectedContextAwareInterface {

	/**
	 * Filters given array of nodes by the categories property
	 *
	 * @param array $nodes
	 * @param string $categoryIdentifier
	 * @return array
	 */
	public function byCategory(array $nodes, $categoryIdentifier) {
		$filteredNodes = array();
		/** @var Node $node  */
		foreach ($nodes as $node) {
			$haystack = $node->getProperty('categories', TRUE);
			if (is_array($haystack) && in_array($categoryIdentifier, $haystack)) {
				$filteredNodes[] = $node;
			}
		}
		return $filteredNodes;
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
