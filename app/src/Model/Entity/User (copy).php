<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'username' => true,
        'password' => true,
        'salt' => true,
        'group_id' => true,
        'role' => true,
        'is_active' => true,
        'last_login' => true,
        'last_ip' => true,
        'old_salt' => true,
        'old_hash' => true,
        'force_reset' => true,
        'fraudulent' => true,
        'group' => true,
    ];
}
