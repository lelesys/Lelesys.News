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
class SortHelper implements ProtectedContextAwareInterface {

	/**
	 * Sorts the array of given nodes by given property ASC/DESC
	 *
	 * @param array $nodes Nodes to sort
	 * @param string $propertyName Property name to sort on
	 * @param string $order Sort order one of ASC or DESC
	 * @return array
	 */
	public function by(array $nodes, $propertyName, $order = 'DESC') {
		$sortedNodes = array();
		$sortSequence = array();
		$nodesByIdentifier = array();
		/** @var Node $node  */
		foreach ($nodes as $node) {
			$propertyValue = $node->getProperty($propertyName);
			if ($propertyValue instanceof \DateTime) {
				$propertyValue = $propertyValue->getTimestamp();
			}
			$sortSequence[$node->getIdentifier()] = $propertyValue;
			$nodesByIdentifier[$node->getIdentifier()] = $node;
		}
		if ($order === 'DESC') {
			arsort($sortSequence);
		} else {
			asort($sortSequence);
		}
		foreach ($sortSequence as $nodeIdentifier => $value) {
			$sortedNodes[] = $nodesByIdentifier[$nodeIdentifier];
		}
		return $sortedNodes;
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
