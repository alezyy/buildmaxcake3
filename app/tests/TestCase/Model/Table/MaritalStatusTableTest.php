<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaritalStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaritalStatusTable Test Case
 */
class MaritalStatusTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'MaritalStatus' => 'app.marital_status',
        'Tenants' => 'app.tenants',
        'Alternateemails' => 'app.alternateemails',
        'Cities' => 'app.cities',
        'States' => 'app.states',
        'Countries' => 'app.countries',
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
        $config = TableRegistry::exists('MaritalStatus') ? [] : ['className' => 'App\Model\Table\MaritalStatusTable'];
        $this->MaritalStatus = TableRegistry::get('MaritalStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MaritalStatus);

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
}
