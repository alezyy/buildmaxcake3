<?php
namespace App\Test\TestCase\Controller;

use App\Controller\LeasestypesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\LeasestypesController Test Case
 */
class LeasestypesControllerTest extends IntegrationTestCase
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
