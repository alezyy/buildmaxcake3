<?php
namespace App\Model\Table;

use App\Model\Entity\Unit;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Units Model
 */
class UnitsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('units');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('ApplicationsLeases', [
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
            ->add('id_property', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_property')
            ->allowEmpty('unit_number')
            ->add('size', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('size')
            ->add('market_rent', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('market_rent')
            ->allowEmpty('country')
            ->allowEmpty('street')
            ->allowEmpty('city')
            ->allowEmpty('state')
            ->allowEmpty('postal_code')
            ->allowEmpty('bedrooms')
            ->add('bath', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('bath')
            ->allowEmpty('description')
            ->allowEmpty('features')
            ->requirePresence('status', 'create')
            ->notEmpty('status')
            ->allowEmpty('photo');

        return $validator;
    }
}
