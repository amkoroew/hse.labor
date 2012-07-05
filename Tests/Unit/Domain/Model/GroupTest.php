<?php
namespace HSE\Labor\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for Group
 */
class GroupTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function testNewGroupIsEmpty() {
		$group = new \HSE\Labor\Domain\Model\Group;
		$this->assertTrue($group->getStudents()->isEmpty());
	}
}
