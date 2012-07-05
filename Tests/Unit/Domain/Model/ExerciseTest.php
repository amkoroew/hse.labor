<?php
namespace HSE\Labor\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for Exercise
 */
class ExerciseTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function testExercisesCanBeSetToNotRequired() {
		$exercise = new \HSE\Labor\Domain\Model\Exercise;
		$exercise->setRequired(false);
		$this->assertFalse($exercise->getRequired());
	}

	/**
	 * @test
	 */
	public function beforeAddingNewExerciseToALabTheExerciseHasNoLabSet() {
		$exercise = new \HSE\Labor\Domain\Model\Exercise;
		$this->assertNull($exercise->getLab());
	}

	/**
	 * @test
	 */
	public function afterAddingNewExerciseToALabTheExerciseHasTheLabSet() {
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$exercise = new \HSE\Labor\Domain\Model\Exercise;
		$lab->addExercise($exercise);
		$this->assertEquals($lab, $exercise->getLab());
	}
}
