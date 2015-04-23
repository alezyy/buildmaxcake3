<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmploymentAndIncomeHistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmploymentAndIncomeHistoryTable Test Case
 */
class EmploymentAndIncomeHistoryTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'EmploymentAndIncomeHistory' => 'app.employment_and_income_history'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EmploymentAndIncomeHistory') ? [] : ['className' => 'App\Model\Table\EmploymentAndIncomeHistoryTable'];
        $this->EmploymentAndIncomeHistory = TableRegistry::get('EmploymentAndIncomeHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmploymentAndIncomeHistory);

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
