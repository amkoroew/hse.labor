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
	 * @var \HSE\Labor\Domain\Repository\LabRepository
	 */
	protected $labRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\ExerciseRepository
	 */
	protected $exerciseRepository;

	/**
	 * @FLOW3\Inject
	 * @var \HSE\Labor\Domain\Repository\StudentExerciseRepository
	 */
	protected $studentExerciseRepository;

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * @param \TYPO3\FLOW3\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	*/
	protected function initializeView(\TYPO3\FLOW3\Mvc\View\ViewInterface $view) {
		$view->assign('modules', $this->moduleRepository->findAll());
		$party = $this->securityContext->getParty();
		$view->assign('party', $party);
		if($party instanceof \HSE\Labor\Domain\Model\Student) {
			$stats = array();
			foreach($this->moduleRepository->findAll() as $module) {
				$moduleStats['module'] = $module;
				$moduleStat['requiredExercisesCount']     = $party->getRequiredExercisesCountByModule($module);
				$moduleStat['requiredAnsweredCount']      = $party->getRequiredAnsweredCountByModule($module);
				$moduleStat['requiredAnsweredPercentage'] = $party->getRequiredAnsweredPercentageByModule($module);
				$moduleStat['optionalExercisesCount']     = $party->getOptionalExercisesCountByModule($module);
				$moduleStat['optionalAnsweredCount']      = $party->getOptionalAnsweredCountByModule($module);
				$moduleStat['optionalAnsweredPercentage'] = $party->getOptionalAnsweredPercentageByModule($module);
				$moduleStats['stats'] = $moduleStat;
				$stats['modules'][] = $moduleStats;
			}
			$this->view->assign('stats', $stats);
		}
	}
}
