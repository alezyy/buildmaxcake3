<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comptable Entity.
 */
class Comptable extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_tenants' => true,
        'id_payments' => true,
    ];
}
