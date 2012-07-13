<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Exercise
 *
 * @FLOW3\Entity
 */
class Exercise implements ExerciseInterface {

	/**
	 * The lab
	 * @var \HSE\Labor\Domain\Model\Lab
	 * @ORM\ManyToOne(inversedBy="exercises")
	 */
	protected $lab;

	/**
	 * The exercise number
	 * @var integer
	 */
	protected $exerciseNumber;

	/**
	 * The question
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $question;

	/**
	 * The hint
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $hint;

	/**
	 * The answer
	 * @var string
	 */
	protected $answer;

	/**
	 * The active
	 * @var boolean
	 */
	protected $active;

	/**
	 * The required
	 * @var boolean
	 */
	protected $required;

	/**
	 * The students
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise>
	 * @ORM\OneToMany(mappedBy="exercise")
	 */
	protected $students;

	/**
	 * Constructs a Exercise
	 */
	public function __construct() {
		$this->students = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Exercise's lab
	 *
	 * @return \HSE\Labor\Domain\Model\Lab The Exercise's lab
	 */
	public function getLab() {
		return $this->lab;
	}

	/**
	 * Sets this Exercise's lab
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab The Exercise's lab
	 * @return void
	 */
	public function setLab(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->lab = $lab;
	}

	/**
	 * Get the Exercise's exercise number
	 *
	 * @return integer The Exercise's exercise number
	 */
	public function getExerciseNumber() {
		return $this->exerciseNumber;
	}

	/**
	 * Sets this Exercise's exercise number
	 *
	 * @param integer $exerciseNumber The Exercise's exercise number
	 * @return void
	 */
	public function setExerciseNumber($exerciseNumber) {
		$this->exerciseNumber = $exerciseNumber;
	}

	/**
	 * Get the Exercise's question
	 *
	 * @return string The Exercise's question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * Sets this Exercise's question
	 *
	 * @param string $question The Exercise's question
	 * @return void
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * Get the Exercise's hint
	 *
	 * @return string The Exercise's hint
	 */
	public function getHint() {
		return $this->hint;
	}

	/**
	 * Sets this Exercise's hint
	 *
	 * @param string $hint The Exercise's hint
	 * @return void
	 */
	public function setHint($hint) {
		$this->hint = $hint;
	}

	/**
	 * Get the Exercise's answer
	 *
	 * @return string The Exercise's answer
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * Sets this Exercise's answer
	 *
	 * @param string $answer The Exercise's answer
	 * @return void
	 */
	public function setAnswer($answer) {
		$this->answer = $answer;
	}

	/**
	 * Is the exercise active
	 *
	 * @return boolean
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Sets this Exercise's active
	 *
	 * @param boolean $active The Exercise's active
	 * @return void
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * Is the exercise required
	 *
	 * @return boolean
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * Sets this Exercise's required
	 *
	 * @param boolean $required The Exercise's required
	 * @return void
	 */
	public function setRequired($required) {
		$this->required = $required;
	}

	/**
	 * Get the Exercise's students
	 *
	 * @return \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\StudentExercise> The Exercise's students
	 */
	public function getStudents() {
		return $this->students;
	}

	/**
	 * Adds a student to the exercise
	 *
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise The studentExercise to add.
	 * @return void
	 */
	public function addStudent($studentExercise) {
		$this->students->add($studentExercise);
	}

	/**
	 * Removes a student from this exercise
	 *
	 * @param \HSE\Labor\Domain\Model\StudentExercise $studentExercise The student to remove from this exercise
	 * @return void
	 */
	public function removeStudent($studentExercise) {
		$this->students->removeElement($studentExercise);
	}
}
