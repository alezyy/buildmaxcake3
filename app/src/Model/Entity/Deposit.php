<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Deposit Entity.
 */
class Deposit extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'security_deposit' => true,
    ];
}
