<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Module controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class ModuleController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * Index action
	 *
	 * @FLOW3\SkipCsrfProtection
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('students', $this->studentRepository->findAll());
		$this->view->assign('activeTokens', $this->securityContext->getAuthenticationTokens());
	}

	/**
	 * Show action
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module Thr module to show
	 * @return void
	 */
	public function showAction($module) {
		$this->view->assign('labs', $module->getLabs());
		$this->view->assign('currentModule', $module);
	}

	/**
	 * Displays a form for a new Module
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Creates a new Module
	 *
	 * @param \HSE\Labor\Domain\Model\Module $newModule A new Module
	 * @return void
	 */
	public function createAction(\HSE\Labor\Domain\Model\Module $newModule) {
		$this->moduleRepository->add($newModule);
		$this->addFlashMessage('Your new module was created.');
		$this->redirect('index');
	}

	/**
	 * Display a form for editing an existing Module
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module The module to edit
	 * @FLOW3\IgnoreValidation("$module")
	 * @return void
	 */
	public function editAction(\HSE\Labor\Domain\Model\Module $module) {
		$this->view->assign('module', $module);
	}

	/**
	 * Updates an existing Module
	 *
	 * @param \HSE\Labor\Domain\Model\Module
	 * @return void
	 */
	public function updateAction(\HSE\Labor\Domain\Model\Module $module) {
		$this->moduleRepository->update($module);
		$this->addFlashMessage('Your module has been updated.');
		$this->redirect('index', 'module');
	}

	/**
	 * Deletes an existing Module
	 *
	 * @param \HSE\Labor\Domain\Model\Module
	 * @return void
	 */
	public function deleteAction(\HSE\Labor\Domain\Model\Module $module) {
		$this->moduleRepository->remove($module);
		$this->addFlashMessage('Your module has been deleted.');
		$this->redirect('index', 'module');
	}
}
