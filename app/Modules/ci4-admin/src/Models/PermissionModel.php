<?php

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Admin\Entities\Permission;

class PermissionModel extends Model
{
    use \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;
    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table     = 'auth_permissions';
    protected $tableLang = false;

    protected $allowedFields = [
        'name', 'description'
    ];
    protected $returnType     = Permission::class;
    protected $useTimestamps  = false;
    protected $useSoftDeletes = false;

    protected $validationRules = [
        'name' => 'required|max_length[255]|is_unique[auth_permissions.name,id,{id}]',
        'description' => 'max_length[255]',
    ];

    const ORDERABLE = [
        1 => 'name',
        2 => 'description',
    ];

    public static $orderable = ['name', 'description'];

    public function __construct()
    {
        parent::__construct();
        $this->auth_groups_permissions = $this->db->table('auth_groups_permissions');
        $this->builder = $this->db->table('auth_permissions');
    }

    /**
     * Checks to see if a user, or one of their groups,
     * has a specific permission.
     *
     * @param $userId
     * @param $permissionId
     *
     * @return bool
     */
    public function doesUserHavePermission(int $userId, int $permissionId): bool
    {
        // Check user permissions and take advantage of caching
        $userPerms = $this->getPermissionsForUser($userId);

        if (count($userPerms) && array_key_exists($permissionId, $userPerms)) {
            return true;
        }

        // Check group permissions
        $count = $this->db->table('auth_groups_permissions')
            ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups_permissions.group_id', 'inner')
            ->where('auth_groups_permissions.permission_id', $permissionId)
            ->where('auth_groups_users.user_id', $userId)
            ->countAllResults();

        return $count > 0;
    }

    /**
     * Adds a single permission to a single user.
     *
     * @param int $permissionId
     * @param int $userId
     *
     * @return \CodeIgniter\Database\BaseResult|\CodeIgniter\Database\Query|false
     */
    public function addPermissionToUser(int $permissionId, int $userId)
    {
        cache()->delete("{$userId}_permissions");

        return $this->db->table('auth_users_permissions')->insert([
            'user_id' => $userId,
            'permission_id' => $permissionId
        ]);
    }

    /**
     * Removes a permission from a user.
     *
     * @param int $permissionId
     * @param int $userId
     *
     * @return mixed
     */
    public function removePermissionFromUser(int $permissionId, int $userId)
    {
        $this->db->table('auth_users_permissions')->where([
            'user_id' => $userId,
            'permission_id' => $permissionId
        ])->delete();

        cache()->delete("{$userId}_permissions");
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
    public function getPermissionsForUser(int $userId): array
    {
        if (!$found = cache("{$userId}_permissions")) {
            $fromUser = $this->db->table('auth_users_permissions')
                ->select('id, auth_permissions.name')
                ->join('auth_permissions', 'auth_permissions.id = permission_id', 'inner')
                ->where('user_id', $userId)
                ->get()
                ->getResultObject();
            $fromGroup = $this->db->table('auth_groups_users')
                ->select('auth_permissions.id, auth_permissions.name')
                ->join('auth_groups_permissions', 'auth_groups_permissions.group_id = auth_groups_users.group_id', 'inner')
                ->join('auth_permissions', 'auth_permissions.id = auth_groups_permissions.permission_id', 'inner')
                ->where('user_id', $userId)
                ->get()
                ->getResultObject();

            $combined = array_merge($fromUser, $fromGroup);

            $found = [];
            foreach ($combined as $row) {
                $found[$row->id] = strtolower($row->name);
            }

            cache()->save("{$userId}_permissions", $found, 300);
        }

        return $found;
    }

    public function getAllList(int $page, int $perpage, array $sort, array $query)
    {
        return $this->getBaseAllList($page, $perpage, $sort, $query, $this->searchKtDatatable);
    }


    public static function getNatifById(int $id)
    {
        $db = \Config\Database::connect();
        $permission = $db->table('auth_permissions')->select('is_natif')->where(['id' => $id])->get()->getRow();
        return $permission->is_natif;
    }

    public function getPermissionsByIdGroup(int $groupId)
    {
        return $this->db->table('auth_groups_permissions')
            ->where('group_id', $groupId)
            ->get()->getResult();
    }

    public function getPermission()
    {
        return $this->db->table('auth_permissions')
            ->get()->getResult();
    }

    public function permissionByIdGroupGroupUser(int $userId)
    {
        return $this->db->table('auth_users_permissions')
            ->where('user_id', $userId)
            ->get()->getResult();
    }

    public function deletePerm(int $permission_id)
    {
        $this->db->table('auth_permissions')->delete(['id' => $permission_id]);
        $this->db->table('auth_users_permissions')->where('permission_id', $permission_id)->delete();
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
        $builder =  $this->db->table('auth_permissions')
            ->select('*');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('name', $search)
                ->orLike('description', $search)
            ->groupEnd();

        return $condition->where([
            'auth_permissions.deleted_at'  => null,
            'auth_permissions.deleted_at' => null,
        ]);
    }

    public function createPermissions(array $data){

        if(empty($data) || !is_array($data))
            return false;
         // On insére le role par default au user
         foreach ($data as $row) {
            $tabRow =  $this->db->table('auth_permissions')->where(['name' => $row['name']])->get()->getRow();
            if (empty($tabRow)) {
                // No langue - add the row
                $this->db->table('auth_permissions')->insert($row);
            }
        }

    }

}
