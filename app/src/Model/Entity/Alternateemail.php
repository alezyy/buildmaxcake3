<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Alternateemail Entity.
 */
class Alternateemail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'tenant_id' => true,
        'alternate_email' => true,
        'tenant' => true,
    ];
}
