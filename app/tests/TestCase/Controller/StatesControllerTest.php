<?php
namespace App\Test\TestCase\Controller;

use App\Controller\StatesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\StatesController Test Case
 */
class StatesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'States' => 'app.states',
        'Countries' => 'app.countries',
        'Cities' => 'app.cities',
        'Tenants' => 'app.tenants',
        'Alternateemails' => 'app.alternateemails',
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
