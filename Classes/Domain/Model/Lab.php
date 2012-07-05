<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Lab
 *
 * @FLOW3\Entity
 */
class Lab {

	/**
	 * The module
	 * @var \HSE\Labor\Domain\Model\Module
	 * @ORM\ManyToOne(inversedBy="labs")
	 */
	protected $module;

	/**
	 * The lab number
	 * @var integer
	 */
	protected $labNumber;

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The number of exercises
	 * @var integer
	 */
	protected $numberOfExercises;

	/**
	 * The exercises
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Exercise>
	 * @ORM\OneToMany(mappedBy="lab")
	 * @ORM\OrderBy({"exerciseNumber" = "ASC"})
	 */
	protected $exercises;

	/**
	 * Constructs a new Lab
	 */
	public function __construct() {
		$this->exercises = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Lab's module
	 *
	 * @return \HSE\Labor\Domain\Model\Module The Lab's module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * Sets this Lab's module
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module The Lab's module
	 * @return void
	 */
	public function setModule(\HSE\Labor\Domain\Model\Module $module) {
		$this->module = $module;
	}

	/**
	 * Get the Lab's lab number
	 *
	 * @return integer The Lab's lab number
	 */
	public function getLabNumber() {
		return $this->labNumber;
	}

	/**
	 * Sets this Lab's lab number
	 *
	 * @param integer $labNumber The Lab's lab number
	 * @return void
	 */
	public function setLabNumber($labNumber) {
		$this->labNumber = $labNumber;
	}

	/**
	 * Get the Lab's name
	 *
	 * @return string The Lab's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Lab's name
	 *
	 * @param string $name The Lab's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Lab's number of exercises
	 *
	 * @return integer The Lab's number of exercises
	 */
	public function getNumberOfExercises() {
		return $this->numberOfExercises;
	}

	/**
	 * Sets this Lab's number of exercises
	 *
	 * @param integer $numberOfExercises The Lab's number of exercises
	 * @return void
	 */
	public function setNumberOfExercises($numberOfExercises) {
		$this->numberOfExercises = $numberOfExercises;
	}

	/**
	 * Get the Lab's exercises
	 *
	 * @return \Doctrine\Common\Collections\Collection The Lab's exercises
	 */
	public function getExercises() {
		return $this->exercises;
	}

	/**
	 * Add a exercise to this lab
	 *
	 * @param \HSE\Labor\Domain\Model\Exercise $exercise The exercise to add
	 * @return void
	 */
	public function addExercise(\HSE\Labor\Domain\Model\Exercise $exercise) {
		$exercise->setLab($this);
		$this->exercises->add($exercise);
	}

	/**
	 * Get random exercises of this lab
	 * The number of exercises to return is defined by $this->numberOfExercises
	 *
	 * @return \Doctrine\Common\Collections\Collection Random exercises of this lab
	 */
	public function getRandomExercises() {
		$exercises = $this->getExercises();
		for($i = $exercises->count() - 1; $i > 0; --$i) {
			$index = mt_rand(0, $i);
			$temp = $exercises->offsetGet($i);
			$exercises->offsetSet($i, $exercises->offsetGet($index));
			$exercises->offsetSet($index, $temp);
		}
		$randomExercises = $exercises->slice(0, $this->getNumberOfExercises());
		$result = array();
		foreach($randomExercises as $randomExercise) {
			$result[$randomExercise->getExerciseNumber()] = $randomExercise;
		}
		ksort($result);
		return new \Doctrine\Common\Collections\ArrayCollection($result);
	}
}
