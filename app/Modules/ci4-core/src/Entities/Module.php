<?php

namespace Adnduweb\Ci4Core\Entities;

use CodeIgniter\Entity\Entity;

class Module extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
