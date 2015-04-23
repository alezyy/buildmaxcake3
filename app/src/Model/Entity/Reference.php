<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reference Entity.
 */
class Reference extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id_tenant' => true,
        'reference_first_name_1' => true,
        'reference_last_name_1' => true,
        'phone_1' => true,
        'first_name_2' => true,
        'last_name_2' => true,
        'phone_2' => true,
    ];
}
