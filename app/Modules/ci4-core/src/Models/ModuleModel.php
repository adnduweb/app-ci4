<?php

namespace Adnduweb\Ci4Core\Models;
use Adnduweb\Ci4Core\Entities\Module;
use CodeIgniter\Model;

class ModuleModel extends Model
{
    use \Adnduweb\Ci4Core\Traits\AuditsTrait;

    protected $DBGroup          = 'default';
    protected $table            = 'modules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType     = Module::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'handle', 'class', 'is_natif', 'is_installed', 'active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['auditInsert'];
    protected $beforeUpdate   = ['auditUpdate'];
    protected $afterUpdate    = ['auditDelete'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getModuleByHandle( string $handle)
    {
        return $this->db->table($this->table)->where('handle', $handle)->get()->getRow();
    }

}
