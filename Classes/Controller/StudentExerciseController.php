<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * StudentExercise controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class StudentExerciseController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * @param \HSE\Labor\Domain\Model\Lab $lab
	 * @return void
	 */
	public function indexAction($lab) {
		$student = $this->securityContext->getParty();
		$this->view->assign('studentExercises', $student->getExercisesByLab($lab));
	}
	
	/**
	 * Display a StudentExercise
	 *
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise
	 * @return void
	 */
	public function showAction(\HSE\Labor\Domain\Model\StudentExercise $studentExercise) {
		$this->view->assign('studentExercise', $studentExercise);
		$this->view->assign('currentModule', $studentExercise->getLab()->getModule());
		$this->view->assign('currentLab', $studentExercise->getLab());
		$this->view->assign('currentExercise', $studentExercise);
	}

	/**
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise
	 * @param string answer
	 * @return void
	 */
	public function verifyAction($studentExercise, $answer) {
		if(preg_match($studentExercise->getAnswer(), $answer)) {
			$student = $studentExercise->getStudent();
			foreach($student->getExercises() as $exercise) {
				if($exercise === $studentExercise) {
					$exercise->setAnswered(true);
				}
			}
			$this->studentRepository->update($student);
			$this->addFlashMessage('Your answer was correct.', 'Exercise verification', \TYPO3\FLOW3\Error\Message::SEVERITY_OK);
			$this->redirect('show', 'Lab', NULL, array('lab' => $studentExercise->getLab()));
		} else {
			$this->addFlashMessage('Your answer was wrong.', 'Exercise verification', \TYPO3\FLOW3\Error\Message::SEVERITY_NOTICE);
			$this->redirect('show', 'StudentExercise', NULL, array('studentExercise' => $studentExercise));
		}
	}
}
