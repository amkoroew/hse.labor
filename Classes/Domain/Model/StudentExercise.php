<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A StudentExercise
 *
 * @FLOW3\Entity
 */
class StudentExercise implements StudentInterface, ExerciseInterface {

	/**
	 * The student
	 * @var \HSE\Labor\Domain\Model\Student
	 * @ORM\ManyToOne(inversedBy="exercises")
	 */
	protected $student;

	/**
	 * The exercise
	 * @var \HSE\Labor\Domain\Model\Exercise
	 * @ORM\ManyToOne(inversedBy="students")
	 */
	protected $exercise;

	/**
	 * Exercise already answered
	 * @var boolean
	 */
	protected $answered;


	/**
	 * Constructs a new StudentExercise
	 *
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise
	 * @return void
	 */
	public function __construct($student, $exercise) {
		$this->student = $student;
		$this->exercise = $exercise;
		$this->answered = false;
	}

	/**
	 * @param \HSE\Labor\Domain\Model\Student $student
	 * @return void
	 */
	public function setStudent($student) {
		$this->student = $student;
	}

	/**
	 * @return \HSE\Labor\Domain\Model\Student
	 */
	public function getStudent() {
		return $this->student;
	}

	/**
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise
	 * @return void
	 */
	public function setExercise($exercise) {
		$this->exercise = $exercise;
	}

	/**
	 * @return \HSE\Labor\Domain\Model\Exercise
	 */
	public function getExercise() {
		return $this->exercise;
	}

	/**
	 * @param boolean $answered
	 * @return void
	 */
	public function setAnswered($answered) {
		$this->answered = $answered;
	}

	/**
	 * @return boolean
	 */
	public function getAnswered() {
		return $this->answered;
	}

	/**
	 * @param \HSE\Labor\Domain\Model\Student
	 * @return void
	 */
	public function addStudent($student) {
		$this->exercise->addStudent($student);
	}

	/**
	 * @return \HSE\Labor\Domain\Model\Lab
	 */
	public function getLab() {
		return $this->exercise->getLab();
	}

	/**
	 * @return integer
	 */
	public function getExerciseNumber() {
		return $this->exercise->getExerciseNumber();
	}

	/**
	 * @return string
	 */
	public function getQuestion() {
		return $this->exercise->getQuestion();
	}

	/**
	 * @return string
	 */
	public function getHint() {
		return $this->exercise->getHint();
	}

	/**
	 * @return string
	 */
	public function getAnswer() {
		return $this->exercise->getAnswer();
	}

	/**
	 * @return boolean
	 */
	public function getRequired() {
		return $this->exercise->getRequired();
	}
}
