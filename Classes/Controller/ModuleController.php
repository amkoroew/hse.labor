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
		$this->redirect('index', 'Module', NULL, array('module' => $newModule));
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
		$this->redirect('index', 'Module', NULL, array('module' => $module));
	}

	/**
	 * Populate database
	 *
	 * Inserts Modules, Labs and Exercises specified in given XML file
	 * into the database.
	 *
	 * @return void
	 */
	public function populateAction() {
		if ($this->request->getArguments() === array()) {
			$this->addFlashMessage('No XML file submitted.', 'File upload', \TYPO3\FLOW3\Error\Message::SEVERITY_NOTICE);
			$this->redirect('index', 'Module');
		} else {
			$file = $this->request->getArgument('file');
			$xml_modules = simplexml_load_file($file['tmp_name']);
			
			foreach($xml_modules->module as $xml_module) {
				$module = $this->moduleRepository->findOneByName((string)$xml_module->name);
				if($module === NULL) {
					$module = new \HSE\Labor\Domain\Model\Module();
					$module->setName((string)$xml_module->name);
					$this->moduleRepository->add($module);
				}
				foreach($xml_module->labs->lab as $xml_lab) {
					$lab = NULL;
					foreach($module->getLabs() as $module_lab) {
						if($module_lab->getName() === (string)$xml_lab->name) {
							$lab = $module_lab;
						}
					}
					if($lab === NULL) {
						$lab = new \HSE\Labor\Domain\Model\Lab();
						$lab->setName((string)$xml_lab->name);
						$lab->setLabNumber((int)$xml_lab->labNumber);
						$lab->setNumberOfExercises((int)$xml_lab->numberOfExercises);
						$module->addLab($lab);
						$this->moduleRepository->update($module);
					}
					foreach($xml_lab->exercises->exercise as $xml_exercise) {
						$exercise = NULL;
						foreach($lab->getExercises() as $lab_exercise) {
							if($lab_exercise->getExerciseNumber() === (int)$xml_exercise->exerciseNumber) {
								$exercise = $lab_exercise;
							}
						}
						if($exercise === NULL) {
							$exercise = new \HSE\Labor\Domain\Model\Exercise();
							$exercise->setExerciseNumber((int)$xml_exercise->exerciseNumber);
							$exercise->setActive(strtoupper((string)$xml_exercise->active) === 'TRUE');
							$exercise->setRequired(strtoupper((string)$xml_exercise->required) === 'TRUE');
							$exercise->setQuestion((string)$xml_exercise->question);
							$exercise->setHint((string)$xml_exercise->hint);
							$exercise->setAnswer((string)$xml_exercise->answer);
							$lab->addExercise($exercise);
							$this->moduleRepository->update($module);
							$this->exerciseRepository->add($exercise);
						}
					}
				}
			}
		}

		$this->addFlashMessage(' XML file parsed');
		$this->redirect('index', 'Module');
	}

	/**
	 * Deletes an existing Module
	 *
	 * @param \HSE\Labor\Domain\Model\Module
	 * @return void
	 */
	public function deleteAction(\HSE\Labor\Domain\Model\Module $module) {
		foreach($this->studentExerciseRepository->findAll() as $studentExercise) {
			if($studentExercise->getLab()->getModule() === $module) {
				$this->addFlashMessage('An Exercise of this Module is assigned to a student. NOT deleted!');
				$this->redirect('index', 'module');
			}
		}
		foreach($module->getLabs() as $lab) {
			foreach($lab->getExercises() as $exercise) {
				$this->exerciseRepository->remove($exercise);
			}
			$this->labRepository->remove($lab);
		}
		$this->moduleRepository->remove($module);
		$this->addFlashMessage('Your module has been deleted.');
		$this->redirect('index', 'module');
	}
}
