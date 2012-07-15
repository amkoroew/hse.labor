<?php
namespace HSE\Labor\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Exercise controller for the HSE.Labor package 
 *
 * @FLOW3\Scope("singleton")
 */
class ExerciseController extends \HSE\Labor\Controller\AbstractBaseController {

	/**
	 * Index action
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab
	 * @return void
	 */
	public function indexAction($lab) {
		$this->view->assign('lab', $lab);
		$this->view->assign('exercises', $lab->getExercises());
	}

	/**
	 * Display a Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise
	 * @return void
	 */
	public function showAction(\HSE\Labor\Domain\Model\Exercise $exercise) {
		$this->view->assign('exercise', $exercise);
	}

	/**
	 * Displays a form for a new Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab
	 * @return void
	 */
	public function newAction(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->view->assign('lab', $lab);
		$newExercise = new \HSE\Labor\Domain\Model\Exercise;
		$newExercise->setActive(true);
		$newExercise->setRequired(true);
		$this->view->assign('newExercise', $newExercise);
	}

	/**
	 * Creates a new Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab The lab the new exercise belongs to
	 * @param \HSE\Labor\Domain\Model\Exercise $newExercise A new Exercise
	 * @return void
	 */
	public function createAction(\HSE\Labor\Domain\Model\Lab $lab, \HSE\Labor\Domain\Model\Exercise $newExercise) {
		$lab->addExercise($newExercise);
		$this->exerciseRepository->add($newExercise);
		$this->addFlashMessage('Your new exercise was created.');
		$this->redirect('show', 'exercise', NULL, array('exercise' => $newExercise));
	}

	/**
	 * Display a form for editing an existing Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise The exercise to edit
	 * @FLOW3\IgnoreValidation("$exercise")
	 * @return void
	 */
	public function editAction(\HSE\Labor\Domain\Model\Exercise $exercise) {
		$this->view->assign('exercise', $exercise);
	}

	/**
	 * Updates an existing Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Exercise
	 * @return void
	 */
	public function updateAction(\HSE\Labor\Domain\Model\Exercise $exercise) {
		$this->exerciseRepository->update($exercise);
		$this->addFlashMessage('Your exercise has been updated.');
		$this->redirect('show', 'exercise', NULL, array('exercise' => $exercise));
	}

	/**
	 * Deletes an existing Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise
	 * @return void
	 */
	public function deleteAction(\HSE\Labor\Domain\Model\Exercise $exercise) {
		$lab = $exercise->getLab();
		foreach($this->studentExerciseRepository->findAll() as $studentExercise) {
			if($studentExercise->getExercise() === $exercise) {
				$this->addFlashMessage('This Exercise is assigned to a student. NOT deleted!');
				$this->redirect('index', 'exercise', NULL, array('lab' => $lab));
			}
		}
		$this->exerciseRepository->remove($exercise);
		$lab->removeExercise($exercise);
		$this->labRepository->update($lab);
		$this->addFlashMessage('Your exercise has been deleted.');
		$this->redirect('index', 'exercise', NULL, array('lab' => $lab));
	}

	/**
	 * Verifies an Exercise
	 *
	 * @param \HSE\Labor\Domain\Model\StudentExercise $exercise
	 * @param string $answer
	 * @return void
	 */
	public function verifyAction(\HSE\Labor\Domain\Model\Exercise $exercise, \string $answer) {
		if($exercise->getAnswer() === $answer) {
			$exercise->setAnswered(true);
			$this->exerciseRepository->update($exercise);
			$this->addFlashMessage('Your answer was correct.');
		} else {
			$this->addFlashMessage('Your answer was wrong.');
		}
		$this->redirect('index', 'module');
	}

	/**
	 * Setup action
	 *
	 * @return void
	 */
	public function setupAction() {
		$modules = $this->moduleRepository->findAll();
		foreach($modules as $module) {
			foreach($module->getLabs() as $lab) {
				for($qn = 1; $qn <= 30; ++$qn) {
					$q = new \HSE\Labor\Domain\Model\Exercise;
					$q->setLab($lab);
					$q->setExerciseNumber($qn);
					$q->setQuestion($qn);
					$q->setHint($qn);
					$q->setAnswer($qn);
					$q->setActive(true);
					$q->setRequired(true);
					$this->exerciseRepository->add($q);
				}
			}
		}
		$this->addFlashMessage('Exercises added to the labs.');
		$this->redirect('index', 'module');
	}
}
