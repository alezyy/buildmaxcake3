<?php
namespace App\Model\Table;

use App\Model\Entity\EmploymentAndIncomeHistory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmploymentAndIncomeHistory Model
 */
class EmploymentAndIncomeHistoryTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('employment_and_income_history');
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
            ->allowEmpty('employer_name')
            ->allowEmpty('city')
            ->allowEmpty('employer_phone')
            ->add('employed_from', 'valid', ['rule' => 'date'])
            ->allowEmpty('employed_from')
            ->add('employed_till', 'valid', ['rule' => 'date'])
            ->allowEmpty('employed_till')
            ->add('monthly_gross_pay', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('monthly_gross_pay')
            ->allowEmpty('occupation')
            ->allowEmpty('additional_income_2nd_job')
            ->allowEmpty('assets')
            ->allowEmpty('notes');

        return $validator;
    }
}
