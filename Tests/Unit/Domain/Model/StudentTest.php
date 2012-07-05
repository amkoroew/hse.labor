<?php
namespace HSE\Labor\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for Student
 */
class StudentTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function testExercisesOfStudentEmptyAtStart() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$this->assertTrue($student->getExercises()->isEmpty());
	}

	/**
	 * @test
	 */
	public function noAnsweredExercisesAtStart() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$this->assertEquals(0, $student->getAnsweredCount());
	}

	/**
	 * @test
	 */
	public function oneAnsweredExerciseAfterAnsweringOne() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$this->assertEquals(1, $student->getAnsweredCount());
	}

	/**
	 * @test
	 */
	public function zeroPercentSolvedAtStart() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$this->assertEquals('0', $student->getAnsweredPercentage());
	}

	/**
	 * @test
	 */
	public function hundretPercentSolvedAtEnd() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$this->assertEquals('100', $student->getAnsweredPercentage());
	}

	/**
	 * @test
	 */
	public function percentRoundedToLower() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(FALSE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(FALSE);
		$student->addExercise($studentExercise);
		$this->assertEquals('33', $student->getAnsweredPercentage());
	}

	/**
	 * @test
	 */
	public function percentRoundedToHigher() {
		$student = new \HSE\Labor\Domain\Model\Student;
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(TRUE);
		$student->addExercise($studentExercise);
		$exercise = new \HSE\Labor\Domain\Model\Exercise();
		$studentExercise = new \HSE\Labor\Domain\Model\StudentExercise($student, $exercise);
		$studentExercise->setAnswered(FALSE);
		$student->addExercise($studentExercise);
		$this->assertEquals('67', $student->getAnsweredPercentage());
	}
}
