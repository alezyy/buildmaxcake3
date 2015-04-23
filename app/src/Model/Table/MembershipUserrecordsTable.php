<?php
namespace App\Model\Table;

use App\Model\Entity\MembershipUserrecord;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MembershipUserrecords Model
 */
class MembershipUserrecordsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('membership_userrecords');
        $this->displayField('id');
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create')
            ->allowEmpty('tableName')
            ->allowEmpty('pkValue')
            ->allowEmpty('id_membership_user')
            ->allowEmpty('dateAdded')
            ->allowEmpty('dateUpdated')
            ->add('id_membership_group', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_membership_group');

        return $validator;
    }
}
