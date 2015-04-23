<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * State Entity.
 */
class State extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'country_id' => true,
        'state' => true,
        'country' => true,
        'cities' => true,
        'tenants' => true,
    ];
}
