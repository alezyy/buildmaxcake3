<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembershipGrouppermission Entity.
 */
class MembershipGrouppermission extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_membership_group' => true,
        'tableName' => true,
        'allowInsert' => true,
        'allowView' => true,
        'allowEdit' => true,
        'allowDelete' => true,
    ];
}
