<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApplicationsLeasesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApplicationsLeasesTable Test Case
 */
class ApplicationsLeasesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'ApplicationsLeases' => 'app.applications_leases',
        'Tenants' => 'app.tenants',
        'Properties' => 'app.properties',
        'Units' => 'app.units'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ApplicationsLeases') ? [] : ['className' => 'App\Model\Table\ApplicationsLeasesTable'];
        $this->ApplicationsLeases = TableRegistry::get('ApplicationsLeases', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ApplicationsLeases);

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
