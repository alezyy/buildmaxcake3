<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResidenceAndRentalHistory Entity.
 */
class ResidenceAndRentalHistory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_tenant' => true,
        'address' => true,
        'landlord_or_manager_name' => true,
        'landlord_or_manager_phone' => true,
        'monthly_rent' => true,
        'date_of_residency_from' => true,
        'date_of_residency_to' => true,
        'reason_for_leaving' => true,
        'notes' => true,
    ];
}
