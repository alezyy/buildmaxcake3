<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comptable1 Entity.
 */
class Comptable1 extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tenant_id' => true,
        'payment_id' => true,
        'tenant' => true,
        'payment' => true,
    ];
}
