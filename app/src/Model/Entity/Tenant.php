<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tenant Entity.
 */
class Tenant extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'phone' => true,
        'birth_date' => true,
        'driver_license_number' => true,
        'driver_license_state' => true,
        'total_number_of_occupants' => true,
        'unit_or_address_applying_for' => true,
        'requested_lease_term' => true,
        'status' => true,
        'emergency_contact' => true,
        'co_signer_details' => true,
        'notes' => true,
        'photo' => true,
    ];
}
