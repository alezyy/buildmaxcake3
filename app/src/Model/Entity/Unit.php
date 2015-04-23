<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Unit Entity.
 */
class Unit extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_property' => true,
        'unit_number' => true,
        'size' => true,
        'market_rent' => true,
        'country' => true,
        'street' => true,
        'city' => true,
        'state' => true,
        'postal_code' => true,
        'bedrooms' => true,
        'bath' => true,
        'description' => true,
        'features' => true,
        'status' => true,
        'photo' => true,
    ];
}
