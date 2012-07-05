<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * AbstractBase controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
abstract class AbstractBaseController extends \TYPO3\FLOW3\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\FLOW3\Security\Context
	 * @FLOW3\Inject
	 */
	protected $securityContext;

	/**
	 * @FLOW3\Inject
	 * @var \TYPO3\Party\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\StudentRepository
	 */
	protected $studentRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\ModuleRepository
	 */
	protected $moduleRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\ExerciseRepository
	 */
	protected $exerciseRepository;

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * @param \TYPO3\FLOW3\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	*/
	protected function initializeView(\TYPO3\FLOW3\Mvc\View\ViewInterface $view) {
		$view->assign('modules', $this->moduleRepository->findAll());
		$view->assign('party', $this->securityContext->getParty());
	}
}
