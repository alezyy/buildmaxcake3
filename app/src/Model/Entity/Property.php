<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Property Entity.
 */
class Property extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'property_name' => true,
        'id_unit' => true,
        'type' => true,
        'number_of_units' => true,
        'id_rental_owner' => true,
        'operating_account' => true,
        'property_reserve' => true,
        'rental_amount' => true,
        'deposit_amount' => true,
        'lease_term' => true,
        'country' => true,
        'street' => true,
        'City' => true,
        'State' => true,
        'ZIP' => true,
        'photo' => true,
    ];
}
