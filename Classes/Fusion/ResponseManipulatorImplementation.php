<?php
namespace Lelesys\News\Fusion;

/*
 * This file is part of the Lelesys.News package.
 *
 * (c) Lelesys
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Core\Bootstrap;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Typoscript Response Manupulator
 *
 * @api
 */
class ResponseManipulatorImplementation extends AbstractFusionObject
{
    /**
     * Inject bootstrap
     *
     * @Flow\Inject
     * @var Bootstrap
     */
    protected $bootstrap;

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function evaluate()
    {
        $response = $this->bootstrap->getActiveRequestHandler()->getHttpResponse();
        $response->setHeader('Content-Type', 'application/xml');
    }
}
