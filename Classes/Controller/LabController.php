<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Lab controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class LabController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * Index action
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module
	 * @return void
	 */
	public function indexAction(\HSE\Labor\Domain\Model\Module $module) {
		//$this->view->assign('activeExercises', $this->exerciseRepository->findActiveByLab($lab));
		$this->view->assign('module', $module);
		$this->view->assign('labs', $module->getLabs());
	}

	/**
	 * Displays a Lab
	 *
	 * Lists the exercises of the lab
	 * @param \HSE\Labor\Domain\Model\Lab $lab
	 * @FLOW3\SkipCsrfProtection
	 * @return void
	 */
	public function showAction(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->view->assign('lab', $lab);
		$this->view->assign('currentModule', $lab->getModule());
		$this->view->assign('currentLab', $lab);
		//if($this->securityContext->hasRole('Administrator')) {
		//	$this->view->assign('exercises', $lab->getExercises());
		//} else {
		//	$student = $this->securityContext->getParty();
		//	$this->view->assign('studentExercises', $student->getExercisesByLab($lab));
		//}
	}

	/**
	 * Displays a form for a new Lab
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module
	 * @return void
	 */
	public function newAction(\HSE\Labor\Domain\Model\Module $module) {
		$this->view->assign('module', $module);
	}

	/**
	 * Creates a new Lab
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module The module the new lab belongs to
	 * @param \HSE\Labor\Domain\Model\Lab $newLab A new Lab
	 * @return void
	 */
	public function createAction(\HSE\Labor\Domain\Model\Module $module, \HSE\Labor\Domain\Model\Lab $newLab) {
		$module->addLab($newLab);
		$this->labRepository->add($newLab);
		$this->addFlashMessage('Your new lab was created.');
		$this->redirect('show', 'lab', NULL, array('lab' => $newLab));
	}

	/**
	 * Display a form for editing an existing Lab
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab The lab to edit
	 * @FLOW3\IgnoreValidation("$lab")
	 * @return void
	 */
	public function editAction(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->view->assign('lab', $lab);
	}

	/**
	 * Updates an existing Lab
	 *
	 * @param \HSE\Labor\Domain\Model\Lab
	 * @return void
	 */
	public function updateAction(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->labRepository->update($lab);
		$this->addFlashMessage('Your lab has been updated.');
		$this->redirect('show', 'lab', NULL, array('lab' => $lab));
	}

	/**
	 * Deletes an existing Lab
	 *
	 * @param \HSE\Labor\Domain\Model\Lab
	 * @return void
	 */
	public function deleteAction(\HSE\Labor\Domain\Model\Lab $lab) {
		$module = $lab->getModule();
		foreach($lab->getExercises() as $exercise) {
			$this->exerciseRepository->remove($exercise);
		}
		$module->removeLab($lab);
		$this->labRepository->remove($lab);
		$this->addFlashMessage('Your lab has been deleted.');
		$this->redirect('index', 'lab', NULL, array('module' => $module));
	}
}
