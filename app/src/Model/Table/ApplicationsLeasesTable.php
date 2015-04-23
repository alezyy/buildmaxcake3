<?php
namespace App\Model\Table;

use App\Model\Entity\ApplicationsLease;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApplicationsLeases Model
 */
class ApplicationsLeasesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('applications_leases');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id'
        ]);
        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id'
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id'
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
            ->requirePresence('type', 'create')
            ->notEmpty('type')
            ->add('start_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('start_date')
            ->add('end_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('end_date')
            ->allowEmpty('recurring_charges_frequency')
            ->add('next_due_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('next_due_date')
            ->allowEmpty('rent')
            ->add('security_deposit', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('security_deposit')
            ->add('security_deposit_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('security_deposit_date')
            ->requirePresence('status', 'create')
            ->notEmpty('status')
            ->allowEmpty('notes')
            ->allowEmpty('agreement');

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
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));
        $rules->add($rules->existsIn(['property_id'], 'Properties'));
        $rules->add($rules->existsIn(['unit_id'], 'Units'));
        return $rules;
    }
}
