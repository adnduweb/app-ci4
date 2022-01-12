<?php

namespace Adnduweb\Ci4Core\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Core\Entities\Audit;

class AuditModel extends Model
{
    protected $table      = 'audits';
    protected $primaryKey = 'id';

    protected $returnType     = Audit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['source', 'source_id', 'user_id', 'event', 'summary', 'data', 'created_at'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    const ORDERABLE = [
        1 => 'id',
        2 => 'source',
        3 => 'event',
        4 => 'source_id',
        5 => 'user_id',
        6 => 'created_at',
    ];

    public static $orderable = ['source', 'event', 'source_id', 'user_id', 'data', 'created_at'];

    public function getLastLogsUser( int $user_id, int $limit){

        return $this->db->table('audits')->where('user_id', $user_id)->orderBy('id', 'DESC')->get($limit)->getResult();
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
        $builder =  $this->db->table('audits')
            ->select('*');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('source', $search)
                ->orLike('event', $search)
            ->groupEnd();

        return $condition;
    }

}
