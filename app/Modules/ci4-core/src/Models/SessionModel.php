<?php

namespace Adnduweb\Ci4Core\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{ 
    protected $table      = 'sessions';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'ip_address', 'user_agent', 'timestamp', 'data'];


        /** 
     * Delete session User
     */
    public function deleteSessionUserOther($user_id = null, $id = null){

        $sessionsUser = $this->builder()
        ->select(['id'])
        ->where('user_id =' . $user_id . ' AND id != "' .$id. '"')
        ->get()->getResult();

        $returnSession = [];
        if(!empty($sessionsUser)){
            $i = 0;
            foreach( $sessionsUser as $session){
                $this->builder()->delete(['id' => $session->id]);
                $returnSession[] =  $session->id;
                $i++;
            }
        }

        return $returnSession;
    }

    public function getSessionsUser( int $user_id ){
        
        return  $this->builder()->select()->where('user_id =' . $user_id)->get()->getResult();
    }
    
}
