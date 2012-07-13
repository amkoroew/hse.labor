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
		$this->view->assign('students', $this->studentRepository->findAll());
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
	 * Display a form for editing a Student
	 *
	 * @param \HSE\Labor\Domain\Model\Student $student The student to edit
	 * @FLOW3\IgnoreValidation("$student")
	 * @return void
	 */
	public function editAction(\HSE\Labor\Domain\Model\Student $student) {
		$this->view->assign('student', $student);
		$this->view->assign('exercises', $this->exerciseRepository->findAll());
		$this->view->assign('assignedExercises', $student->getExercises());
	}

	/**
	 * Updates an existing Student
	 *
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @param \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Exercise> $exercises
	 * @return void
	 */
	public function updateAction(\HSE\Labor\Domain\Model\Student $student, $exercises) {
		$studentExercises = new \Doctrine\Common\Collections\ArrayCollection();
		foreach($exercises as $exercise) {
			$studentExercises->add(new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise));
		}
		$student->setExercises($studentExercises);
		$this->studentRepository->update($student);
		$this->addFlashMessage('The student has been updated.');
		//$this->redirect('show', 'student', NULL, array('student' => $student));
		$this->redirect('index', 'module');
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
