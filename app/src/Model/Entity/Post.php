<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity.
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'post_file' => true,
        'publish_date' => true,
        'is_published' => true,
        'parent_id' => true,
        'user_id' => true,
        'content' => true,
        'parent_post' => true,
        'user' => true,
        'child_posts' => true,
    ];
}
