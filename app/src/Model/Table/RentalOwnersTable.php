<?php
namespace App\Model\Table;

use App\Model\Entity\RentalOwner;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RentalOwners Model
 */
class RentalOwnersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('rental_owners');
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
            ->allowEmpty('company_name')
            ->add('date_of_birth', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_of_birth')
            ->allowEmpty('primary_email')
            ->allowEmpty('alternate_email')
            ->allowEmpty('phone')
            ->allowEmpty('country')
            ->allowEmpty('street')
            ->allowEmpty('city')
            ->allowEmpty('state')
            ->add('zip', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('zip')
            ->allowEmpty('comments');

        return $validator;
    }
}
