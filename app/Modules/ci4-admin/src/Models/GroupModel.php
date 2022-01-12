<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;
use  Adnduweb\Ci4Admin\Entities\Group;

class GroupModel extends Model
{
    use \Adnduweb\Ci4Core\Traits\AuditsTrait;
    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table = 'auth_groups';
    protected $primaryKey = 'id';

    protected $returnType = Group::class;
    protected $localizeFile = 'App\Models\GroupModel';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 'description', 'login_destination'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|max_length[255]|is_unique[auth_groups.name,name,{name}]',
        'description' => 'max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    
    const ORDERABLE = [
        1 => 'name',
        2 => 'description',
        3 => 'login_destination'
    ];

    public static $orderable = ['name', 'description', 'login_destination'];


    public function __construct()
    {
        parent::__construct();
        $this->auth_groups = $this->db->table('auth_groups');
    }


    //--------------------------------------------------------------------
    // Users
    //--------------------------------------------------------------------

    /**
     * Adds a single user to a single group.
     *
     * @param $userId
     * @param $groupId
     *
     * @return object
     */
    public function addUserToGroup(int $userId, int $groupId)
    {
        cache()->delete("{$userId}_groups");
        cache()->delete("{$userId}_permissions");

        $data = [
            'user_id'   => (int) $userId,
            'group_id'  => (int) $groupId
        ];

        $auth_groups_users = $this->db->table('auth_groups_users')->where($data)->get()->getRow();
        if (empty($auth_groups_users)) {
            return $this->db->table('auth_groups_users')->insert($data);
        }
    }

    /**
     * Removes a single user from a single group.
     *
     * @param $userId
     * @param $groupId
     *
     * @return bool
     */
    public function removeUserFromGroup(int $userId, $groupId)
    {
        cache()->delete("{$userId}_groups");
        cache()->delete("{$userId}_permissions");


        return $this->db->table('auth_groups_users')
            ->where([
                'user_id' => (int) $userId,
                'group_id' => (int) $groupId
            ])->delete();
    }

    /**
     * Removes a single user from all groups.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function removeUserFromAllGroups(int $userId)
    {
        cache()->delete("{$userId}_groups");
        cache()->delete("{$userId}_permissions");

        return $this->db->table('auth_groups_users')
            ->where('user_id', (int) $userId)
            ->delete();
    }

    /**
     * Returns an array of all groups that a user is a member of.
     *
     * @param $userId
     *
     * @return array
     */
    public function getGroupsForUser(int $userId)
    {
        if (!$found = cache("{$userId}_groups")) {
            $found = $this->builder()
                ->select('auth_groups_users.*, auth_groups.name, auth_groups.description, auth_groups.login_destination')
                ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id', 'left')
                ->where('user_id', $userId)
                ->get()->getResultArray();

            cache()->save("{$userId}_groups", $found, 300);
        }

        return $found;
    }

    /**
     * Returns an array of all users that are members of a group.
     *
     * @param $groupId
     *
     * @return array
     */
    public function getUsersForGroup(int $groupId)
    {
        if (! $found = cache("{$groupId}_users"))
        {
            $found = $this->builder()
                ->select('auth_groups_users.*, users.*')
                ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id', 'left')
                ->join('users', 'auth_groups_users.user_id = users.id', 'left')
                ->where('auth_groups.id', $groupId)
                ->get()->getResultArray();

            cache()->save("{$groupId}_users", $found, 300);
        }

        return $found;
    }


    //--------------------------------------------------------------------
    // Permissions
    //--------------------------------------------------------------------

     /**
     * Gets all permissions for a group in a way that can be
     * easily used to check against:
     *
     * [
     *  id => name,
     *  id => name
     * ]
     *
     * @param int $groupId
     *
     * @return array
     */
    public function getPermissionsForGroup(int $groupId): array
    {
        $permissionModel = model(PermissionModel::class);
        $fromGroup = $permissionModel
            ->select('auth_permissions.*')
            ->join('auth_groups_permissions', 'auth_groups_permissions.permission_id = auth_permissions.id', 'inner')
            ->where('group_id', $groupId)
            ->findAll();

        $found = [];
        foreach ($fromGroup as $permission)
        {
            $found[$permission['id']] = $permission;
        }

        return $found;
    }


    /**
     * Add a single permission to a single group, by IDs.
     *
     * @param $permissionId
     * @param $groupId
     *
     * @return mixed
     */
    public function addPermissionToGroup(int $permissionId, int $groupId)
    {
        $data = [
            'permission_id' => (int) $permissionId,
            'group_id'      => (int) $groupId
        ];
        $auth_groups_permissions = $this->db->table('auth_groups_permissions')->where($data)->get()->getRow();
        if (empty($auth_groups_permissions)) {
            return $this->db->table('auth_groups_permissions')->insert($data);
        }
    }

    //--------------------------------------------------------------------


    /**
     * Removes a single permission from a single group.
     *
     * @param $permissionId
     * @param $groupId
     *
     * @return mixed
     */
    public function removePermissionFromGroup(int $permissionId, int $groupId)
    {


        // TODO Supprimer de tous les users le cache de permission pour rafraichir
        // A voir si c'est permittent avec x users ou on attends la fin du cache de 300
        // $path = WRITEPATH . 'cache/';
        // foreach (glob($path . "*_permissions") as $file) {
        //     cache()->delete(str_replace($path, '', $file));
        // }

        return $this->db->table('auth_groups_permissions')
            ->where([
                'permission_id' => $permissionId,
                'group_id'      => $groupId
            ])->delete();
    }

    //--------------------------------------------------------------------

    /**
     * Removes a single permission from all groups.
     *
     * @param $permissionId
     *
     * @return mixed
     */
    public function removePermissionFromAllGroups(int $permissionId)
    {
        return $this->db->table('auth_groups_permissions')
            ->where('permission_id', $permissionId)
            ->delete();
    }

    public function isSuperAdmin(int $userId)
    {
        $construct = $this->db->table('auth_groups_users')
            ->select('auth_groups_users.group_id')
            ->where(['user_id' => $userId, 'group_id' => 1])
            ->get()->getRow();
        // Super Admin
        if ($construct->group_id == 1) {
            return true;
        }
        return false;
    }


    public function getGroupsForUserLight(int $userId)
    {
        $return = [];
        $auth_groups_users = $this->db->table('auth_groups_users')
            ->where('user_id', $userId)
            ->get()->getResultArray();

        if (!empty($auth_groups_users)) {
            foreach ($auth_groups_users as $auth_groups_user) {
                $return[$auth_groups_user['group_id']] = $auth_groups_user['group_id'];
            }
        }
        return $return;
    }

    public function getAllList(int $page, int $perpage, array $sort, array $query)
    {
        $this->auth_groups->select();
        $this->auth_groups->select('created_at as date_create_at');
        if (isset($query[0]) && is_array($query)) {
            $this->auth_groups->where('deleted_at IS NULL AND (name LIKE "%' . $query[0] . '%" OR login_destination LIKE "%' . $query[0] . '%")');
            $this->auth_groups->limit(0, $page);
        } else {
            $this->auth_groups->where('deleted_at IS NULL');
            $page = ($page == '1') ? '0' : (($page - 1) * $perpage);
            $this->auth_groups->limit($perpage, $page);
        }


        $this->auth_groups->orderBy($sort['field'] . ' ' . $sort['sort']);

        $groupsRow = $this->auth_groups->get()->getResult();

        //echo $this->auth_groups->getCompiledSelect(); exit;
        return $groupsRow;
    }

    public function getAllCount(array $sort, array $query)
    { 
        $this->auth_groups->select('id');
        if (isset($query[0]) && is_array($query)) {
            $this->auth_groups->where('deleted_at IS NULL AND (name LIKE "%' . $query[0] . '%" OR login_destination LIKE "%' . $query[0] . '%")');
        } else {
            $this->auth_groups->where('deleted_at IS NULL');
        }

        $this->auth_groups->orderBy($sort['field'] . ' ' . $sort['sort']);

        $users = $this->auth_groups->get();
        return $users->getResult();
    }

    /**
     * Returns an array of one group .
     *
     * @param $groupId
     *
     * @return object
     */
    public function getGroupById(int $groupId)
    {
        return $this->builder()
            ->select('auth_groups.name, auth_groups.description')
            ->where('id', $groupId)
            ->get()->getRow();
    }


    public function isAffectGroup(int $group_id)
    {
        $auth_groups_users = $this->db->table('auth_groups_users')->where('group_id', $group_id)->get()->getRow();
        if (empty($auth_groups_users)) {
            return false;
        } else {
            return true;
        }
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
        $builder =  $this->db->table('auth_groups')
            ->select('*');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('name', $search)
                ->orLike('description', $search)
            ->groupEnd();

        return $condition->where([
            'auth_groups.deleted_at'  => null,
            'auth_groups.deleted_at' => null,
        ]);
    }
}
