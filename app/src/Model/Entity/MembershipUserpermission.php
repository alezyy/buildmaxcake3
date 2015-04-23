<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembershipUserpermission Entity.
 */
class MembershipUserpermission extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_membership_user' => true,
        'tableName' => true,
        'allowInsert' => true,
        'allowView' => true,
        'allowEdit' => true,
        'allowDelete' => true,
    ];
}
