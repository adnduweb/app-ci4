<?php

namespace Adnduweb\Ci4Admin\Models;

use Michalsn\Uuid\UuidModel;
use Adnduweb\Ci4Admin\Models\GroupModel;
use Adnduweb\Ci4Admin\Entities\User;
use Exception;


class UserModel extends UuidModel
{ 
    use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;

    protected $afterInsert = ['auditInsert', 'addToGroup'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table      = 'users';
    //protected $with       = ['auth_groups_users', 'auth_users_permissions', 'settings'];
    protected $with       = [];
    protected $without    = [];
    protected $primaryKey = 'id';
    protected $uuidFields = ['uuid'];
    //protected $uuidUseBytes = false;

    protected $returnType     = User::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;

    protected $allowedFields = [
        'uuid', 'company_id', 'lang', 'lastname', 'firstname', 'fonction', 'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'two_factor',
        'two_factor_confirmed', 'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'phone', 'phone_mobile', 'is_principal', 'last_login_at', 'last_login_ip', 'deleted_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $lastLoginAt = 'last_login_at';

    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     *
     * @var int|null
     */
    protected $assignGroup;



    protected $searchKtDatatable  = ['fonction', 'lastname', 'firstname', 'email', 'created_at'];

    const ORDERABLE = [
        1 => 'fonction',
        2 => 'lastname',
        3 => 'firstname',
        4 => 'email',
        6 => 'created_at',
    ];

    public static $orderable = ['fonction', 'lastname', 'firstname' , 'email', 'created_at'];


    public function __construct()
    {
        parent::__construct();
        $this->builder           = $this->db->table('users');
        $this->auth_groups_users = $this->db->table('auth_groups_users');
        $this->auth_groups       = $this->db->table('auth_groups');
        $this->auth_logins       = $this->db->table('auth_logins');
        $this->companies         = $this->db->table('companies');
    }

    /**
     * Logs a password reset attempt for posterity sake.
     *
     * @param string      $email
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     *
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

     /**
     * Sets the group to assign any users created.
     *
     * @param string $groupName
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup))
        {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }


    public function getLastConnexions(int $id, $limit = 100000): array
    {
        $this->auth_logins->select();
        $this->auth_logins->where('user_id', $id);
        $this->auth_logins->orderBy('id', 'DESC');
        $this->auth_logins->limit($limit);
        $auth_logins = $this->auth_logins->get();
        return $auth_logins->getResult();
    }

    public function getGroups()
    {
        return $this->auth_groups->select()->get()->getResult();
    }

    public static function isComptePrincipal(int $id)
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->select('id')->where(['id' => $id, 'id' => '1'])->get()->getRow();
        return (!empty($user)) ? true : false;
    }

    public function deleteAllUser(int $id)
    {
        $this->builder->delete(['id' => $id]);
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->db->table('settings_users')->where('user_id', $id)->delete();
    }

    public static function getUserName(int $id)
    {
        $db = \Config\Database::connect();
        $user = $db->table('users')->select('username')->where(['id' => $id])->get()->getRow();
        return $user->username;
    }

    public function getCompany(): array
    {
        $this->companies->select('id, uuid_company, raison_social');
        $this->companies->orderBy('id', 'DESC');
        $company = $this->companies->get();
        return $company->getResult();
    }

    public function deleteSession($sessionId)
    {
        $this->db->table('sessions')->where('id', $sessionId)->delete();
    }
 
    /**
     * 
     * 
     */
    public function getUserByUUID(string $uuid)
    {
        $uuid = $this->uuid->fromString($uuid)->getBytes();
        $this->builder->where('uuid', $uuid);
        $user = $this->builder->get()->getRowArray();
        return new User($user);
    }

    /**
     * 
     * 
     */
    public function getIdUserByUUID(string $uuid)
    {
        $uuid = $this->uuid->fromString($uuid)->getBytes();
        $this->builder->select('id');
        $this->builder->where('uuid', $uuid);
        return $this->builder->get()->getRow()->id;
    }


    public function get_all_users() {

            $this->builder->select('id');

            $users = $this->builder->get()->getResult();
    
            $temp = [];
            $i = 0;
            if(!empty($users)){
                foreach($users as $user){
                    $temp[] = model(UserModel::class)->with('auth_groups_users')->find($user->id);
                    $i++;
                }
            }
            return $temp;
        }


  /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder =  $this->db->table('users')
            ->select('users.id, uuid, lastname, firstname, email, last_login_at, two_factor, active, users.created_at, auth_groups.name as name, auth_groups.id as group_id ');
            $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'inner');
            $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'inner');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('lastname', $search)
                ->orLike('firstname', $search)
                ->orLike('name', $search)
                ->orLike('email', $search)
            ->groupEnd();

        return $condition->where([
            'users.deleted_at'  => null,
            'users.deleted_at' => null,
        ]);
    }

     /**
     * Gets all permissions for a user in a way that can be
     * easily used to check against:
     *
     * [
     *  id => name,
     *  id => name
     * ]
     *
     * @param int $userId
     *
     * @return array
     */
    public function getListUsersLight(): array
    {
        if (!$found = cache("list_users")) {
                $builder =  $this->db->table('users')
                ->select('users.id, uuid, lastname, firstname, email, last_login_at, two_factor, active, users.created_at, auth_groups.name as name, auth_groups.id as group_id ')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'inner')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'inner')
                ->where(['users.deleted_at' => null,'users.active' => 1 ])
                ->get()
                ->getResultObject();


            $found = [];
            foreach ($builder as $row) {
                $row->uuid = $this->uuid->fromBytes($row->uuid)->toString();
                $found[$row->uuid] = $row;
            }

            cache()->save("list_users", $found, config('Cache')->ttl);
        }

        return $found;
    }

    public function findUserByEmailAddress(string $emailAddress)
    {
        $user = $this->where(['email' => $emailAddress])->first();

        if (!$user) 
            throw new Exception('User does not exist for specified email address');

            return  $user ; 

    }

}
