<?php
namespace App\Model\Table;

use App\Model\Entity\MembershipUserpermission;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MembershipUserpermissions Model
 */
class MembershipUserpermissionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('membership_userpermissions');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->requirePresence('id_membership_user', 'create')
            ->notEmpty('id_membership_user')
            ->allowEmpty('tableName')
            ->add('allowInsert', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('allowInsert')
            ->add('allowView', 'valid', ['rule' => 'numeric'])
            ->requirePresence('allowView', 'create')
            ->notEmpty('allowView')
            ->add('allowEdit', 'valid', ['rule' => 'numeric'])
            ->requirePresence('allowEdit', 'create')
            ->notEmpty('allowEdit')
            ->add('allowDelete', 'valid', ['rule' => 'numeric'])
            ->requirePresence('allowDelete', 'create')
            ->notEmpty('allowDelete');

        return $validator;
    }
}
