<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountriesTable Test Case
 */
class CountriesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Countries' => 'app.countries',
        'Cities' => 'app.cities',
        'States' => 'app.states',
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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Countries') ? [] : ['className' => 'App\Model\Table\CountriesTable'];
        $this->Countries = TableRegistry::get('Countries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Countries);

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
