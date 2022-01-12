<?php 

namespace Adnduweb\Ci4Admin\Entities;

use CodeIgniter\Entity\Entity;

class UserTwoFactors extends Entity
{
    use \Tatter\Relations\Traits\EntityTrait;
    protected $table      = 'auth_users_two_factors';
    protected $primaryKey = 'id';
    protected $datamap = [];

}
