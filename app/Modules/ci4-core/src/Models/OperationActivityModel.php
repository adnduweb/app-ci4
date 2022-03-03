<?php

namespace App\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Core\Entities\OperationActivity;

class OperationActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'operation_activity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = OperationActivity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields        = ['class','operation_id', 'is_editing', 'editing_by', 'user_id'];

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
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
