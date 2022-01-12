<?php 

namespace Adnduweb\Ci4Admin\Entities;

use CodeIgniter\Entity\Entity;

class UserAdresse extends Entity
{
    use \Tatter\Relations\Traits\EntityTrait;
    protected $table      = 'users_adresses';
    protected $primaryKey = 'id';
    protected $datamap = [];

}
