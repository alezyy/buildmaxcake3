<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembershipGroup Entity.
 */
class MembershipGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'description' => true,
        'allowSignup' => true,
        'needsApproval' => true,
    ];
}
