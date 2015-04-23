<?php
namespace App\Model\Table;

use App\Model\Entity\Property;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Properties Model
 */
class PropertiesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('properties');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('PropertiestypesSpecifications', [
            'foreignKey' => 'propertiestypes_specification_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ApplicationsLeases', [
            'foreignKey' => 'property_id'
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
            ->requirePresence('property_name', 'create')
            ->notEmpty('property_name')
            ->allowEmpty('id_unit')
            ->add('number_of_units', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('number_of_units')
            ->add('id_rental_owner', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_rental_owner')
            ->requirePresence('operating_account', 'create')
            ->notEmpty('operating_account')
            ->add('property_reserve', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('property_reserve')
            ->add('rental_amount', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('rental_amount')
            ->add('deposit_amount', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('deposit_amount')
            ->allowEmpty('lease_term')
            ->allowEmpty('country')
            ->allowEmpty('street')
            ->allowEmpty('City')
            ->allowEmpty('State')
            ->add('ZIP', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('ZIP')
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
        $rules->add($rules->existsIn(['propertiestypes_specification_id'], 'PropertiestypesSpecifications'));
        return $rules;
    }
}
