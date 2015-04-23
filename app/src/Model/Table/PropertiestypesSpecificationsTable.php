<?php
namespace App\Model\Table;

use App\Model\Entity\PropertiestypesSpecification;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PropertiestypesSpecifications Model
 */
class PropertiestypesSpecificationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('propertiestypes_specifications');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Propertiestypes', [
            'foreignKey' => 'propertiestype_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Properties', [
            'foreignKey' => 'propertiestypes_specification_id'
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
            ->requirePresence('propertiestypes_specification', 'create')
            ->notEmpty('propertiestypes_specification');

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
        $rules->add($rules->existsIn(['propertiestype_id'], 'Propertiestypes'));
        return $rules;
    }
}
