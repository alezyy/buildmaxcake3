<?php
namespace App\Model\Table;

use App\Model\Entity\MaritalStatus;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaritalStatus Model
 */
class MaritalStatusTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('marital_status');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('Tenants', [
            'foreignKey' => 'marital_status_id'
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
            ->requirePresence('marital_status', 'create')
            ->notEmpty('marital_status');

        return $validator;
    }
}
