<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MembershipUserpermissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MembershipUserpermissionsTable Test Case
 */
class MembershipUserpermissionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'MembershipUserpermissions' => 'app.membership_userpermissions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MembershipUserpermissions') ? [] : ['className' => 'App\Model\Table\MembershipUserpermissionsTable'];
        $this->MembershipUserpermissions = TableRegistry::get('MembershipUserpermissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MembershipUserpermissions);

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
