<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Student
 *
 * @FLOW3\Entity
 */
class Student extends \TYPO3\Party\Domain\Model\Person implements StudentInterface {

	/**
	 * The exercises
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise>
	 * @ORM\OneToMany(mappedBy="student",cascade={"persist"})
	 */
	protected $exercises;

	/**
	 * Constructs a Student
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->exercises = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Constructs a Student
	 *
	 * @param \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Module>
	 * @return void
	 */
//	public function __construct($modules) {
//		parent::__construct();
//		$this->exercises = new \Doctrine\Common\Collections\ArrayCollection();
		/*foreach($modules as $module) {
			foreach($module->getLabs() as $lab) {
				foreach($lab->getRandomExercises() as $randomExercise) {
					$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($this, $randomExercise);
					$this->addExercise($studentExercise);
				}
			}
		}*/

//	}

	/**
	 * Generates the Exercises for this student
	 *
	 * @param \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Module>
	 * @return void
	 */
	public function generateExercises($modules) {
		foreach($modules as $module) {
			foreach($module->getLabs() as $lab) {
				foreach($lab->getRandomExercises() as $randomExercise) {
					$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($this, $randomExercise);
					$this->addExercise($studentExercise);
				}
			}
		}
	}


	/**
	 * @return \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise>
	 */
	public function getExercises() {
		return $this->exercises;
	}

	/**
	 * @param \HSE\Labor\Domain\Model\Lab $lab
	 * @return \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise>
	 */
	public function getExercisesByLab($lab) {
		$exercisesByLab = array();
		foreach($this->exercises as $exercise) {
			if($exercise->getLab() === $lab) {
				$exercisesByLab[$exercise->getExerciseNumber()] = $exercise;
			}
		}
		ksort($exercisesByLab);
		return new \Doctrine\Common\Collections\ArrayCollection($exercisesByLab);
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise>
	 * @return void
	 */
	public function setExercises($studentExercises) {
		foreach($this->exercises as $oldExercise) {
			$oldExercise->remove();
		}
		foreach($studentExercises as $exercise) {
			$exercise->addStudent($this);
		}
		$this->exercises = $studentExercises;
	}

	/**
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise The exercise to add to this student
	 * @return void
	 */
	public function addExercise($studentExercise) {
		$studentExercise->addStudent($studentExercise);
		$this->exercises->add($studentExercise);
	}

	/**
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise The exercise to remove from this student
	 * @return void
	 */
	public function removeExercise($studentExercise) {
		$this->exercises->removeElement($studentExercise);
	}

	/**
	 *
	 */
	public function getExercisesCount() {
		return $this->exercises->count();
	}

	/**
	 *
	 */
	public function getAnsweredCount() {
		$answered = 0;
		foreach($this->exercises as $exercise) {
			if($exercise->getAnswered() === TRUE) {
				++$answered;
			}
		}
		return $answered;
	}

	/**
	 *
	 */
	public function getAnsweredPercentage() {
		if($this->getExercisesCount() == 0) {
			return 0;
		} else {
			return round(($this->getAnsweredCount() / $this->getExercisesCount()) * 100);
		}
	}
}
