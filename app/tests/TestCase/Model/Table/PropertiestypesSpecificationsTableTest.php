<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiestypesSpecificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiestypesSpecificationsTable Test Case
 */
class PropertiestypesSpecificationsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'PropertiestypesSpecifications' => 'app.propertiestypes_specifications',
        'Propertiestypes' => 'app.propertiestypes',
        'Properties' => 'app.properties',
        'ApplicationsLeases' => 'app.applications_leases',
        'Tenants' => 'app.tenants',
        'Units' => 'app.units',
        'Leasestypes' => 'app.leasestypes',
        'Recurringcharges' => 'app.recurringcharges'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PropertiestypesSpecifications') ? [] : ['className' => 'App\Model\Table\PropertiestypesSpecificationsTable'];
        $this->PropertiestypesSpecifications = TableRegistry::get('PropertiestypesSpecifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiestypesSpecifications);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
