<?php
namespace App\Model\Table;

use App\Model\Entity\ResidenceAndRentalHistory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResidenceAndRentalHistory Model
 */
class ResidenceAndRentalHistoryTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('residence_and_rental_history');
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
            ->add('id_tenant', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_tenant')
            ->allowEmpty('address')
            ->allowEmpty('landlord_or_manager_name')
            ->allowEmpty('landlord_or_manager_phone')
            ->add('monthly_rent', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('monthly_rent')
            ->add('date_of_residency_from', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_of_residency_from')
            ->add('date_of_residency_to', 'valid', ['rule' => 'date'])
            ->allowEmpty('date_of_residency_to')
            ->allowEmpty('reason_for_leaving')
            ->allowEmpty('notes');

        return $validator;
    }
}
