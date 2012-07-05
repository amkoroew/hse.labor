<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Group
 *
 * @FLOW3\Entity
 */
class Group {

	/**
	 * The module
	 * @var \HSE\Labor\Domain\Model\Module
	 * @ORM\ManyToOne(inversedBy="groups")
	 */
	protected $module;

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The term
	 * @var string
	 */
	protected $term;

	/**
	 * The students
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Student>
	 * @ORM\ManyToMany(inversedBy="groups")
	 */
	protected $students;

	/**
	 * Constructs a Group
	 */
	public function __construct() {
		$this->students = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Group's module
	 *
	 * @return \HSE\Labor\Domain\Model\Module The Group's module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * Sets this Group's module
	 *
	 * @param \HSE\Labor\Domain\Model\Module $module The Group's module
	 * @return void
	 */
	public function setModule(\HSE\Labor\Domain\Model\Module $module) {
		$this->module = $module;
	}

	/**
	 * Get the Group's name
	 *
	 * @return string The Group's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Group's name
	 *
	 * @param string $name The Group's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Group's term
	 *
	 * @return string The Group's term
	 */
	public function getTerm() {
		return $this->term;
	}

	/**
	 * Sets this Group's term
	 *
	 * @param string $term The Group's term
	 * @return void
	 */
	public function setTerm($term) {
		$this->term = $term;
	}

	/**
	 * Get the Group's students
	 *
	 * @return \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Student> The Group's students
	 */
	public function getStudents() {
		return $this->students;
	}

	/**
	 * Sets this Group's students
	 *
	 * @param \Doctrine\Common\Collections\Collection $students The Group's students
	 * @return void
	 */
	public function setStudents(\Doctrine\Common\Collections\Collection $students) {
		$this->students = $students;
	}

}
