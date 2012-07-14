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
		$students = $this->studentRepository->findAll();
		$this->view->assign('students', $students);

		$stats = array();
		foreach($students as $student) {
			$modules = array();
			$modules['student'] = $student;
			foreach($this->moduleRepository->findAll() as $module) {
				$moduleStats['module'] = $module;
				$moduleStat['requiredExercisesCount']     = $student->getRequiredExercisesCountByModule($module);
				$moduleStat['requiredAnsweredCount']      = $student->getRequiredAnsweredCountByModule($module);
				$moduleStat['requiredAnsweredPercentage'] = $student->getRequiredAnsweredPercentageByModule($module);
				$moduleStat['optionalExercisesCount']     = $student->getOptionalExercisesCountByModule($module);
				$moduleStat['optionalAnsweredCount']      = $student->getOptionalAnsweredCountByModule($module);
				$moduleStat['optionalAnsweredPercentage'] = $student->getOptionalAnsweredPercentageByModule($module);
				$moduleStats['stats'] = $moduleStat;
				$modules['modules'][] = $moduleStats;
			}
			$stats[] = $modules;
		}
		$this->view->assign('stats', $stats);
	}

	/**
	 * Display a Student
	 *
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @return void
	 */
	public function showAction($student) {
		$this->view->assign('student', $student);

		$stats = array();
		foreach($this->moduleRepository->findAll() as $module) {
			$moduleStats['module'] = $module;
			$moduleStat['requiredExercisesCount']     = $student->getRequiredExercisesCountByModule($module);
			$moduleStat['requiredAnsweredCount']      = $student->getRequiredAnsweredCountByModule($module);
			$moduleStat['requiredAnsweredPercentage'] = $student->getRequiredAnsweredPercentageByModule($module);
			$moduleStat['optionalExercisesCount']     = $student->getOptionalExercisesCountByModule($module);
			$moduleStat['optionalAnsweredCount']      = $student->getOptionalAnsweredCountByModule($module);
			$moduleStat['optionalAnsweredPercentage'] = $student->getOptionalAnsweredPercentageByModule($module);
			$moduleStats['stats'] = $moduleStat;
			$stats['modules'][] = $moduleStats;
		}
		$this->view->assign('stats', $stats);
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
}
