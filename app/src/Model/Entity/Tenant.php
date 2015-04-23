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
        'alternateemails_id' => true,
        'cell_phone' => true,
        'home_phone' => true,
        'work_phone' => true,
        'fax' => true,
        'country_id' => true,
        'state_id' => true,
        'street' => true,
        'city_id' => true,
        'zip' => true,
        'birth_date' => true,
        'marital_status_id' => true,
        'driver_license_number' => true,
        'driver_license_state' => true,
        'total_number_of_occupants' => true,
        'unit_or_address_applying_for' => true,
        'requested_lease_term' => true,
        'status' => true,
        'emergency_contact' => true,
        'emergency_contact_email' => true,
        'emergency_contact_phone' => true,
        'relationship_to_tenant' => true,
        'co_signer_details' => true,
        'notes' => true,
        'photo' => true,
    ];
}
