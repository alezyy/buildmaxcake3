<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResidenceAndRentalHistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResidenceAndRentalHistoryTable Test Case
 */
class ResidenceAndRentalHistoryTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'ResidenceAndRentalHistory' => 'app.residence_and_rental_history'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResidenceAndRentalHistory') ? [] : ['className' => 'App\Model\Table\ResidenceAndRentalHistoryTable'];
        $this->ResidenceAndRentalHistory = TableRegistry::get('ResidenceAndRentalHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResidenceAndRentalHistory);

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
