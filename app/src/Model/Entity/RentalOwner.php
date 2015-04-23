<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RentalOwner Entity.
 */
class RentalOwner extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'company_name' => true,
        'date_of_birth' => true,
        'primary_email' => true,
        'alternate_email' => true,
        'phone' => true,
        'country' => true,
        'street' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'comments' => true,
    ];
}
