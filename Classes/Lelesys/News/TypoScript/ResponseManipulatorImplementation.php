<?php
namespace Lelesys\News\TypoScript;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\TypoScript\TypoScriptObjects\AbstractTypoScriptObject;

/**
 * Typoscript Response Manupulator
 *
 * @api
 */
class ResponseManipulatorImplementation extends AbstractTypoScriptObject {

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