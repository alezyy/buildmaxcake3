<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembershipUser Entity.
 */
class MembershipUser extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'passMD5' => true,
        'email' => true,
        'signupDate' => true,
        'id_membership_group' => true,
        'isBanned' => true,
        'isApproved' => true,
        'custom1' => true,
        'custom2' => true,
        'custom3' => true,
        'custom4' => true,
        'comments' => true,
        'pass_reset_key' => true,
        'pass_reset_expiry' => true,
    ];
}
