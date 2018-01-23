<?php
namespace Lelesys\News\Fusion\Eel\FlowQueryOperations;

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
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;

/**
 * Group news nodes collection
 * TODO - this can be optimized a little further to make it work on grouping of
 * any nodes and not only menu items
 */
class GroupOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    static protected $shortName = 'group';

    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    static protected $priority = 100;

    /**
     * {@inheritdoc}
     *
     * We can only handle Menu items for now.
     *
     * @param mixed $context
     * @return boolean
     */
    public function canEvaluate($context)
    {
        return (isset($context[0]['node']) && ($context[0]['node'] instanceof NodeInterface));
    }

    /**
     * {@inheritdoc}
     *
     * @param FlowQuery $flowQuery the FlowQuery object
     * @param array $arguments the arguments for this operation
     * @return mixed
     */
    public function evaluate(FlowQuery $flowQuery, array $arguments)
    {
        $items = $flowQuery->getContext();
        $groupedItems = [];
        foreach ($items as $item) {
            if (isset($item['node'])) {
                $dateTime = $item['node']->getProperty('dateTime');
                if ($dateTime instanceof \DateTime) {
                    $year = $dateTime->format('Y');
                    $month = $dateTime->format('m');
                    $groupedItems[$year][$month][] = $item['node'];
                }
            }
        }
        $flowQuery->setContext($groupedItems);
    }
}
