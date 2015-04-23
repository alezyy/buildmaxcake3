<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MembershipGrouppermissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MembershipGrouppermissionsTable Test Case
 */
class MembershipGrouppermissionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'MembershipGrouppermissions' => 'app.membership_grouppermissions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MembershipGrouppermissions') ? [] : ['className' => 'App\Model\Table\MembershipGrouppermissionsTable'];
        $this->MembershipGrouppermissions = TableRegistry::get('MembershipGrouppermissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MembershipGrouppermissions);

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
