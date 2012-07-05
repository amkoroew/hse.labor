<?php
namespace HSE\Labor\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use Doctrine\ORM\Mapping as ORM;

/**
 * A ExerciseInterface
 */
interface ExerciseInterface {
	/**
	 * @return \HSE\Labor\Domain\Model\Lab
	 */
	public function getLab();

	/**
	 * @return integer
	 */
	public function getExerciseNumber();

	/**
	 * @return string
	 */
	public function getQuestion();

	/**
	 * @return string
	 */
	public function getHint();

	/**
	 * @return string
	 */
	public function getAnswer();

	/**
	 * @return boolean
	 */
	public function getRequired();
}
