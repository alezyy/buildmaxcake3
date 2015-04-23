<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeasestypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeasestypesTable Test Case
 */
class LeasestypesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Leasestypes' => 'app.leasestypes',
        'ApplicationsLeases' => 'app.applications_leases',
        'Tenants' => 'app.tenants',
        'Properties' => 'app.properties',
        'Units' => 'app.units',
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
        $config = TableRegistry::exists('Leasestypes') ? [] : ['className' => 'App\Model\Table\LeasestypesTable'];
        $this->Leasestypes = TableRegistry::get('Leasestypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Leasestypes);

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
