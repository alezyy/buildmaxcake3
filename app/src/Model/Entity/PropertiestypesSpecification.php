<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PropertiestypesSpecification Entity.
 */
class PropertiestypesSpecification extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'propertiestype_id' => true,
        'propertiestypes_specification' => true,
        'propertiestype' => true,
        'properties' => true,
    ];
}
