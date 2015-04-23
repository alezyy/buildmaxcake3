<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MaritalStatus Entity.
 */
class MaritalStatus extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'marital_status' => true,
        'tenants' => true,
    ];
}
