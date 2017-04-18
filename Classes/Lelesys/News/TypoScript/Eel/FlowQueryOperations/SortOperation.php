<?php
namespace Lelesys\News\TypoScript\Eel\FlowQueryOperations;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\ContentRepository\Domain\Model\Node;

/**
 * EEL sort() operation to sort Nodes
 */
class SortOperation extends AbstractOperation {
	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 */
	static protected $shortName = 'sort';

	/**
	 * {@inheritdoc}
	 *
	 * @var integer
	 */
	static protected $priority = 100;

	/**
	 * {@inheritdoc}
	 *
	 * We can only handle TYPO3CR Nodes.
	 *
	 * @param mixed $context
	 * @return boolean
	 */
	public function canEvaluate($context) {
		return (isset($context[0]) && ($context[0] instanceof NodeInterface));
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param FlowQuery $flowQuery the FlowQuery object
	 * @param array $arguments the arguments for this operation
	 * @return mixed
	 */
	public function evaluate(FlowQuery $flowQuery, array $arguments) {
		if (!isset($arguments[0]) || empty($arguments[0])) {
			throw new \Neos\Eel\FlowQuery\FlowQueryException('sort() needs property name by which nodes should be sorted', 1332492263);
		} else {
			$nodes = $flowQuery->getContext();
			$sortByPropertyPath = $arguments[0];
			$sortOrder = 'DESC';
			if (isset($arguments[1]) && !empty($arguments[1]) && in_array($arguments[1], array('ASC', 'DESC'))) {
				$sortOrder = $arguments[1];
			}

			$sortedNodes = array();
			$sortSequence = array();
			$nodesByIdentifier = array();
			/** @var Node $node  */
			foreach ($nodes as $node) {
				$propertyValue = $node->getProperty($sortByPropertyPath);
				if ($propertyValue instanceof \DateTime) {
					$propertyValue = $propertyValue->getTimestamp();
				}
				$sortSequence[$node->getIdentifier()] = $propertyValue;
				$nodesByIdentifier[$node->getIdentifier()] = $node;
			}
			if ($sortOrder === 'DESC') {
				arsort($sortSequence);
			} else {
				asort($sortSequence);
			}
			foreach ($sortSequence as $nodeIdentifier => $value) {
				$sortedNodes[] = $nodesByIdentifier[$nodeIdentifier];
			}
			$flowQuery->setContext($sortedNodes);
		}
	}
}