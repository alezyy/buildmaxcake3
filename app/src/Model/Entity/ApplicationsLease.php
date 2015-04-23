<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApplicationsLease Entity.
 */
class ApplicationsLease extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tenant_id' => true,
        'property_id' => true,
        'unit_id' => true,
        'leasestype_id' => true,
        'start_date' => true,
        'end_date' => true,
        'automatically_end_the_lease' => true,
        'recurringcharge_id' => true,
        'next_due_date' => true,
        'rent_mount' => true,
        'security_deposit' => true,
        'security_deposit_date' => true,
        'status' => true,
        'notes' => true,
        'agreement' => true,
        'tenant' => true,
        'property' => true,
        'unit' => true,
    ];
}
