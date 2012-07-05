<?php
namespace HSE\Labor\Tests\Functional\Controller;
 
/**
 * Verify that we are able to create a new Module
 */
class ModuleControllerTest extends \TYPO3\FLOW3\Tests\FunctionalTestCase {

    /**
     * @var boolean
     */
    static protected $testablePersistenceEnabled = true;
 
    /**
     * @var \HSE\Labor\Domain\Repository\ModuleRepository
     */
    protected $moduleRepository;

    protected $propertyMapper;
 
    /**
     * Initialize repository
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->moduleRepository = new \HSE\Labor\Domain\Repository\ModuleRepository;
	$this->propertyMapper = $this->objectManager->get('TYPO3\FLOW3\Property\PropertyMapper');
    }

    /**
     * Test that we are able to create a new Module  using
     * the "createAction" of the Module controller.
     *
     * We expect that the new Module will be created in the
     * database and can be found using the repository.
     *
     * @test
     * @return void
       */
    public function createNewModule() {
        $arguments = array(
              'name' => 'Test'
        );
 
	$configuration = $this->objectManager->get('TYPO3\FLOW3\Property\PropertyMappingConfigurationBuilder')->build();
	$configuration
		->allowProperties('name');

	$result = $this->propertyMapper->convert($arguments, 'HSE\Labor\Domain\Model\Module',$configuration);
	$this->assertInstanceOf('HSE\Labor\Domain\Model\Module',$result);
	$this->assertEquals('Test', $result->getName());
        // Simulate web request
        //$this->sendWebRequest('Module', 'HSE.Labor', 'create', $result, $format = 'html');
        // Persist the new created Module
        //$this->persistenceManager->persistAll();
 
        //$modules = $this->moduleRepository->findAll();
 
        //$this->assertEquals(1, $modules->count(), 'Unexpected amount of available Modules found.');
 
        //$module = $modules->getFirst();
        //$this->assertEquals($arguments['module']['name'], $module->getName(), 'Module with wrong name.');
    }
}
