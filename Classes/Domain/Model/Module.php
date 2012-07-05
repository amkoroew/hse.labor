<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Module
 *
 * @FLOW3\Entity
 */
class Module {

	/**
	 * The name
	 * @var string
	 */
	protected $name;

	/**
	 * The labs
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Lab>
	 * @ORM\OneToMany(mappedBy="module")
	 * @ORM\OrderBy({"labNumber" = "ASC"})
	 */
	protected $labs;

	/**
	 * The groups
	 * @var \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Group>
	 * @ORM\OneToMany(mappedBy="module")
	 * @ORM\OrderBy({"term" = "DESC"})
	 */
	protected $groups;

	/**
	 * Constructs a new Module
	 */
	public function __construct() {
		$this->labs = new \Doctrine\Common\Collections\ArrayCollection();
		$this->groups = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Module's name
	 *
	 * @return string The Module's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Module's name
	 *
	 * @param string $name The Module's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Module's labs
	 *
	 * @return \Doctrine\Common\Collections\Collection<\HSE\Labor\Domain\Model\Lab> The Module's labs
	 */
	public function getLabs() {
		return $this->labs;
	}

	/**
	 * Add a lab to this module
	 *
	 * @param \HSE\Labor\Domain\Model\Lab $lab The lab to add
	 * @return void
	 */
	public function addLab(\HSE\Labor\Domain\Model\Lab $lab) {
		$lab->setModule($this);
		$this->labs->add($lab);
	}

	/**
	 * Removes a lab from this module
	 *
	 * @param \HSE\Labor\Domain\Model\lab $lab The lab to remove
	 * @return void
	 */
	public function removeLab(\HSE\Labor\Domain\Model\Lab $lab) {
		$this->labs->removeElement($lab);
	}

	/**
	 * Get the Module's groups
	 *
	 * @return \Doctrine\Common\Collections\Collection The Module's groups
	 */
	public function getGroups() {
		return $this->groups;
	}

	/**
	 * Add a group to this module
	 *
	 * @param \HSE\Labor\Domain\Model\Group $group The group to add
	 * @return void
	 */
	public function addGroup(\HSE\Labor\Domain\Model\Group $group) {
		$group->setModule($this);
		$this->groups->add($group);
	}
}
