<?php
namespace App\Model\Table;

use App\Model\Entity\Tenant;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenants Model
 */
class TenantsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('tenants');
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
            ->allowEmpty('first_name')
            ->allowEmpty('last_name')
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email')
            ->allowEmpty('phone')
            ->add('birth_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('birth_date')
            ->allowEmpty('driver_license_number')
            ->allowEmpty('driver_license_state')
            ->allowEmpty('total_number_of_occupants')
            ->allowEmpty('unit_or_address_applying_for')
            ->allowEmpty('requested_lease_term')
            ->requirePresence('status', 'create')
            ->notEmpty('status')
            ->allowEmpty('emergency_contact')
            ->allowEmpty('co_signer_details')
            ->allowEmpty('notes')
            ->allowEmpty('photo');

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
