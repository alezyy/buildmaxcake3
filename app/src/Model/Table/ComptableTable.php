<?php
namespace App\Model\Table;

use App\Model\Entity\Comptable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comptable Model
 */
class ComptableTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('comptable');
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
            ->add('id_tenants', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id_tenants', 'create')
            ->notEmpty('id_tenants')
            ->add('id_payments', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id_payments', 'create')
            ->notEmpty('id_payments');

        return $validator;
    }
}
