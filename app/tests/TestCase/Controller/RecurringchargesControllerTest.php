<?php
namespace App\Test\TestCase\Controller;

use App\Controller\RecurringchargesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\RecurringchargesController Test Case
 */
class RecurringchargesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Recurringcharges' => 'app.recurringcharges',
        'ApplicationsLeases' => 'app.applications_leases',
        'Tenants' => 'app.tenants',
        'Properties' => 'app.properties',
        'PropertiestypesSpecifications' => 'app.propertiestypes_specifications',
        'Propertiestypes' => 'app.propertiestypes',
        'Units' => 'app.units',
        'Leasestypes' => 'app.leasestypes'
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
