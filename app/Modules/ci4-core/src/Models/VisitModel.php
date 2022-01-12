<?php

namespace Adnduweb\Ci4Core\Models;

use CodeIgniter\Model;
use Adnduweb\Ci4Core\Entities\Visit;

class VisitModel extends Model
{
	protected $table      = 'visits';
	protected $primaryKey = 'id';

	protected $returnType = Visit::class;
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'session_id', 'user_id', 'ip_address', 'user_agent', 'views',
		'scheme', 'host', 'port', 'user', 'pass', 'path', 'query', 'fragment', 'created_at',
	];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'host'         => 'required',
		'path'         => 'required',
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	const ORDERABLE = [
        1 => 'ip_address',
		2 => 'user_agent',
		3 => 'path',
		4 => 'created_at'

    ];

	public static $orderable = ['ip_address', 'user_agent', 'path', 'created_at'];
	
	 /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder =  $this->db->table('visits')
            ->select('*');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('ip_address', $search)
				->orLike('user_agent', $search)
				->orLike('path', $search)
            ->groupEnd();

        return $condition;
    }

}
