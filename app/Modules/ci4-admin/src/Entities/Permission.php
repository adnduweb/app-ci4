<?php 

namespace Adnduweb\Ci4Admin\Entities;

use CodeIgniter\Entity\Entity;

class Permission extends Entity
{
    protected $datamap = [];
    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates = [];
    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [];

    public function getFullName(){
        return ucfirst($this->attributes['name']);
    }

}
