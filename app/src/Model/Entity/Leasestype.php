<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Leasestype Entity.
 */
class Leasestype extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'type_lease' => true,
        'applications_leases' => true,
    ];
}
