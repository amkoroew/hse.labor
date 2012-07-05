<?php
namespace HSE\Labor\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "HSE.Labor".                  *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for Module
 */
class ModuleTest extends \TYPO3\FLOW3\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function testRenameModule() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$module->setName('Foo');
		$this->assertEquals('Foo', $module->getName());
	}

	/**
	 * @test
	 */
	public function testNoLabsInitially() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$this->assertTrue($module->getLabs()->isEmpty());
	}

	/**
	 * @test
	 */
	public function testModuleIsAssignedToLabWhenLabIsAddedToModule() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$module->addLab($lab);
		$this->assertSame($module, $lab->getModule());
	}

	/**
	 * @test
	 */
	public function testOneMoreLabAfterALabIsAdded() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$lab =  new \HSE\Labor\Domain\Model\Lab;
		$labCountBeforeAddingLab = $module->getLabs()->count();
		$module->addLab($lab);
		$labCountAfterAddingLab = $module->getLabs()->count();
		$this->assertEquals($labCountBeforeAddingLab + 1, $labCountAfterAddingLab);
	}

	/**
	 * @test
	 */
	public function testLabExistAfterItsAdded() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$module->addLab($lab);
		$this->assertTrue($module->getLabs()->contains($lab));
	}
	
	/**
	 * @test
	 */
	public function testOneLessLabAfterLabIsRemoved() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$lab =  new \HSE\Labor\Domain\Model\Lab;
		$module->addLab($lab);
		$labCountBeforeRemovingLab = $module->getLabs()->count();
		$module->removeLab($lab);
		$labCountAfterRemovingLab = $module->getLabs()->count();
		$this->assertEquals($labCountBeforeRemovingLab - 1, $labCountAfterRemovingLab);
	}

	/**
	 * @test
	 */
	public function testLabDoesntExistAfterItsRemoved() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$lab = new \HSE\Labor\Domain\Model\Lab;
		$module->addLab($lab);
		$module->removeLab($lab);
		$this->assertFalse($module->getLabs()->contains($lab));
	}

	/**
	 * @test
	 */
	public function newModuleHasNoGroup() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$this->assertTrue($module->getGroups()->isEmpty());
	}

	/**
	 * @test
	 */
	public function ModuleContainsGroupAfterTheGroupIsAdded() {
		$module = new \HSE\Labor\Domain\Model\Module;
		$group = new \HSE\Labor\Domain\Model\Group;
		$module->addGroup($group);
		$this->assertTrue($module->getGroups()->contains($group));
	}
}
