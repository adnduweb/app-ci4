<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Admin\Entities\UserTwoFactors;


class UserTwoFactorsModel extends Model
{ 
    use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;

    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table      = 'auth_users_two_factors';
    protected $with       = [];
    protected $without    = [];
    protected $primaryKey = 'id';

    protected $returnType     = UserTwoFactors::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id', 'type', 'two_factor_secret', 'two_factor_recovery_codes', 'opt_mobile', 'opt_email', 'code_temp', 'is_verified', 'two_factor_expires_at', 'created_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getCodeTwoFactorSecret(int $user_id){

        return $this->db->table('auth_users_two_factors')->select('two_factor_secret')
        ->where('user_id', $user_id)
        ->get()
        ->getRow();
    }

    public function getCodeRecovery(int $user_id){
        return $this->db->table('auth_users_two_factors')->select('two_factor_recovery_codes')
        ->where('user_id', $user_id)
        ->get()
        ->getRow();
    }

}
