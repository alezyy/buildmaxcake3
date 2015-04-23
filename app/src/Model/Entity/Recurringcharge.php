<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recurringcharge Entity.
 */
class Recurringcharge extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'frequency' => true,
        'applications_leases' => true,
    ];
}
