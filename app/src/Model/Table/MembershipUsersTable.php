<?php
namespace App\Model\Table;

use App\Model\Entity\MembershipUser;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MembershipUsers Model
 */
class MembershipUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('membership_users');
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
            ->allowEmpty('passMD5')
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email')
            ->add('signupDate', 'valid', ['rule' => 'date'])
            ->allowEmpty('signupDate')
            ->add('id_membership_group', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_membership_group')
            ->add('isBanned', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('isBanned')
            ->add('isApproved', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('isApproved')
            ->allowEmpty('custom1')
            ->allowEmpty('custom2')
            ->allowEmpty('custom3')
            ->allowEmpty('custom4')
            ->allowEmpty('comments')
            ->allowEmpty('pass_reset_key')
            ->add('pass_reset_expiry', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pass_reset_expiry');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
