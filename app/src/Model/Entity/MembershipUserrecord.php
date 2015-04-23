<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembershipUserrecord Entity.
 */
class MembershipUserrecord extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tableName' => true,
        'pkValue' => true,
        'id_membership_user' => true,
        'dateAdded' => true,
        'dateUpdated' => true,
        'id_membership_group' => true,
    ];
}
