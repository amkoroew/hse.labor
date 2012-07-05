<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Student controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class StudentController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('students', $this->partyRepository->findAll());
	}

	/**
	 * Display a Student
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @return void
	 */
	public function showAction(\HSE\Labor\Domain\Model\Module $module, \HSE\Labor\Domain\Model\Student $student) {
		$this->view->assign('student', $student);
		$this->view->assign('labs', $module->getLabs());
	}

	/**
	 * Sets random exercises to the students 
	 *
	 * @return void
	 */
	public function setupAction() {
		$modules = $this->moduleRepository->findAll();
		$students = $this->studentRepository->findAll();
		foreach($students as $student) {
			foreach($modules as $module) {
				foreach($module->getLabs() as $lab) {
					foreach($lab->getRandomExercises() as $exercise) {
						$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
						$student->addExercise($studentExercise);
					}
				}
			}
			$this->studentRepository->update($student);
		}
		$this->addFlashMessage('Random exercises added to the students.');
		$this->redirect('index', 'module');
	}

	/**
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @return void
	 */
	public function testAction($student) {
		foreach($student->getExercises() as $exercise) {
			$exercise->setAnswered(false);
		}
		$this->studentRepository->update($student);
	}
}
