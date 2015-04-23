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
        $this->belongsTo('Alternateemails', [
            'foreignKey' => 'alternateemails_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Accounting', [
            'foreignKey' => 'tenant_id'
        ]);
        $this->hasMany('Alternateemails', [
            'foreignKey' => 'tenant_id'
        ]);
        $this->hasMany('ApplicationsLeases', [
            'foreignKey' => 'tenant_id'
        ]);
        $this->hasMany('Comptable1', [
            'foreignKey' => 'tenant_id'
        ]);
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
            ->allowEmpty('cell_phone')
            ->requirePresence('home_phone', 'create')
            ->notEmpty('home_phone')
            ->allowEmpty('work_phone')
            ->allowEmpty('fax')
            ->requirePresence('street', 'create')
            ->notEmpty('street')
            ->add('zip', 'valid', ['rule' => 'numeric'])
            ->requirePresence('zip', 'create')
            ->notEmpty('zip')
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
            ->requirePresence('emergency_contact_email', 'create')
            ->notEmpty('emergency_contact_email')
            ->requirePresence('emergency_contact_phone', 'create')
            ->notEmpty('emergency_contact_phone')
            ->requirePresence('relationship_to_tenant', 'create')
            ->notEmpty('relationship_to_tenant')
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
        $rules->add($rules->existsIn(['alternateemails_id'], 'Alternateemails'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        return $rules;
    }
}
