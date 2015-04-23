<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity.
 */
class Country extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'country' => true,
        'name' => true,
        'paypal' => true,
        'states' => true,
        'tenants' => true,
    ];
}
