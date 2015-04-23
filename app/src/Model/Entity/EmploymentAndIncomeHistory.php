<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmploymentAndIncomeHistory Entity.
 */
class EmploymentAndIncomeHistory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_tenant' => true,
        'employer_name' => true,
        'city' => true,
        'employer_phone' => true,
        'employed_from' => true,
        'employed_till' => true,
        'monthly_gross_pay' => true,
        'occupation' => true,
        'additional_income_2nd_job' => true,
        'assets' => true,
        'notes' => true,
    ];
}
