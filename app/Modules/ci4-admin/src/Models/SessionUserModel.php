<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;

class SessionUserModel extends Model
{ 
    use \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;

    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table      = 'sessions_users';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['ip_address', 'login_id', 'session_id', 'user_id', 'agent', 'timestamp'];

    /**
     * Delete session User
     */
    public function deleteSessionUserCurrent($user_id = null, $ipAddress = null, $agent = null){

        $sessionUser = $this->builder()
        ->select(['id'])
        ->where(['user_id' => $user_id, 'ip_address' => $ipAddress, 'agent' => $agent])
        ->get()->getRow();

        if(!empty($sessionUser)){
            $this->builder()->delete(['id' => $sessionUser->id]);
        }

        return true;
    }
    
}
