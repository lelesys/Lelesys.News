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

/**
 * Extended EEL filter() operation for News
 */
class FilterOperation extends \Neos\ContentRepository\Eel\FlowQueryOperations\FilterOperation
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    static protected $priority = 200;

    /**
     * @var string
     */
    protected $dateTimeFormat = '';

    /**
     * {@inheritdoc}
     *
     * @param array (or array-like object) $context onto which this operation should be applied
     * @return boolean TRUE if the operation can be applied onto the $context, FALSE otherwise
     */
    public function canEvaluate($context)
    {
        return (isset($context[0]) && ($context[0] instanceof NodeInterface) && $context[0]->getNodeType()->isOfType('Lelesys.News:News'));
    }

    /**
     * {@inheritdoc}
     *
     * @param \Neos\Eel\FlowQuery\FlowQuery $flowQuery
     * @param array $arguments
     * @return void
     */
    public function evaluate(\Neos\Eel\FlowQuery\FlowQuery $flowQuery, array $arguments)
    {
        if (isset($arguments[1]) && is_string($arguments[1]) && !empty($arguments[1])) {
            $this->dateTimeFormat = $arguments[1];
        }
        parent::evaluate($flowQuery, $arguments);
    }

    /**
     * {@inheritdoc}
     *
     * @param object $element
     * @param string $propertyPath
     * @return mixed
     */
    protected function getPropertyPath($element, $propertyPath)
    {
        switch ($propertyPath) {
            case 'categories':
                // this returns array of node identifiers of references and not the nodes itself
                return $element->getProperty($propertyPath, true);
            break;
            case 'dateTime':
                $dateTime = $element->getProperty($propertyPath);
                if ($dateTime instanceof \DateTime) {
                    return (string)$dateTime->format($this->dateTimeFormat);
                }

                return null;
            break;
        }

        return parent::getPropertyPath($element, $propertyPath);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $value
     * @param string $operator
     * @param mixed $operand
     * @return boolean
     */
    protected function evaluateOperator($value, $operator, $operand)
    {
        if ($operator === '*=') {
            if (is_array($value)) {
                if (is_string($operand)) {
                    $operandValues = explode(',', $operand);

                    return count(array_intersect($value, $operandValues)) > 0;
                }

                return false;
            }
        }

        return parent::evaluateOperator($value, $operator, $operand);
    }
}
