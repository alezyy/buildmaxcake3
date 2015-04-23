<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Accounting Entity.
 */
class Accounting extends Entity
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
