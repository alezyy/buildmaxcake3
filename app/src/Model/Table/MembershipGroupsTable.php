<?php
namespace App\Model\Table;

use App\Model\Entity\MembershipGroup;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MembershipGroups Model
 */
class MembershipGroupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('membership_groups');
        $this->displayField('name');
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
            ->allowEmpty('name')
            ->allowEmpty('description')
            ->add('allowSignup', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('allowSignup')
            ->add('needsApproval', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('needsApproval');

        return $validator;
    }
}
