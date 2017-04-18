<?php
namespace Lelesys\News\TypoScript;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Mvc\ActionRequest;

/**
 * Typoscript Response Manupulator
 *
 * @api
 */
class ResponseManipulatorImplementation extends \Neos\Fusion\FusionObjects\AbstractFusionObject {

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
	public function evaluate() {
		$response = $this->bootstrap->getActiveRequestHandler()->getHttpResponse();
		$response->setHeader('Content-Type', 'application/xml');
	}

}