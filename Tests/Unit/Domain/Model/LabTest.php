<?php
namespace HSE\Labor\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for Lab
 */
class LabTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function testSetNumberOfExercises() {
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$lab->setNumberOfExercises(10);
		$this->assertEquals(10, $lab->getNumberOfExercises());
	}

	/**
	 * @test
	 */
	public function newLabHasNoExercises() {
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$this->assertTrue($lab->getExercises()->isEmpty());
	}

	/**
	 * @test
	 */
	public function newLabHasOneExerciseAfterAExerciseIsAdded() {
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$exercise = new \HSE\Labor\Domain\Model\Exercise;
		$lab->addExercise($exercise);
		$this->assertEquals(1, $lab->getExercises()->count());
	}
}
