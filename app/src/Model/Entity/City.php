<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity.
 */
class City extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'state_id' => true,
        'city' => true,
        'state' => true,
        'tenants' => true,
    ];
}
