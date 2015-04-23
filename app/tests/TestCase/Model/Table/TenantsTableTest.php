<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantsTable Test Case
 */
class TenantsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Tenants' => 'app.tenants',
        'Alternateemails' => 'app.alternateemails',
        'Countries' => 'app.countries',
        'States' => 'app.states',
        'Cities' => 'app.cities',
        'Accounting' => 'app.accounting',
        'Payments' => 'app.payments',
        'Comptable1' => 'app.comptable1',
        'ApplicationsLeases' => 'app.applications_leases',
        'Properties' => 'app.properties',
        'PropertiestypesSpecifications' => 'app.propertiestypes_specifications',
        'Propertiestypes' => 'app.propertiestypes',
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
        $config = TableRegistry::exists('Tenants') ? [] : ['className' => 'App\Model\Table\TenantsTable'];
        $this->Tenants = TableRegistry::get('Tenants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tenants);

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
