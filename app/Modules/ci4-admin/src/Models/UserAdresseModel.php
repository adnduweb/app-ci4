<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Admin\Entities\UserAdresse;


class UserAdresseModel extends Model
{ 
    use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;

    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table      = 'users_adresses';
    //protected $with       = ['auth_groups_users', 'auth_users_permissions', 'settings'];
    protected $with       = [];
    protected $without    = [];
    protected $primaryKey = 'id';

    protected $returnType     = UserAdresse::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;

    protected $allowedFields = [
        'user_id', 'country_id', 'adresse1', 'adresse2', 'code_postal', 'ville', 'phone', 'phone_mobile', 'created_at', 'updated_at',
        
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $lastLoginAt = 'last_login_at';

    // protected $validationRules = [
    //     'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
    //     'username'      => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
    //     'password_hash' => 'required',
    // ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
