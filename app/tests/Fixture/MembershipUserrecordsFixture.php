<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembershipUserrecordsFixture
 *
 */
class MembershipUserrecordsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tableName' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'pkValue' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'id_membership_user' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dateAdded' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dateUpdated' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_membership_group' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'pkValue' => ['type' => 'index', 'columns' => ['pkValue'], 'length' => []],
            'tableName' => ['type' => 'index', 'columns' => ['tableName'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tableName_pkValue' => ['type' => 'unique', 'columns' => ['tableName', 'pkValue'], 'length' => []],
        ],
        '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '',
            'tableName' => 'Lorem ipsum dolor sit amet',
            'pkValue' => 'Lorem ipsum dolor sit amet',
            'id_membership_user' => 'Lorem ipsum dolor ',
            'dateAdded' => '',
            'dateUpdated' => '',
            'id_membership_group' => 1
        ],
    ];
}
