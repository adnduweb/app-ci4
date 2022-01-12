<?php

namespace Adnduweb\Ci4Admin\Models;

use Adnduweb\Ci4Admin\Entities\Company;
use Michalsn\Uuid\UuidModel;

class CompanyModel extends UuidModel
{
    use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;

    protected $afterInsert = ['auditInsert'];
    protected $afterUpdate = ['auditUpdate'];
    protected $afterDelete = ['auditDelete'];

    protected $table          = 'companies';
    protected $tableLang      = 'companies_langs';
    protected $with           = [];
    protected $without        = [];
    protected $primaryKey     = 'id';
    protected $primaryKeyLang = 'company_id';
    protected $uuidFields     = ['uuid_company'];

    protected $returnType     = Company::class;
    protected $localizeFile   = 'App\Models\CompanyModel';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid_company', 'company_type_id', 'country_id', 'currency_id', 'raison_social',
        'adresse', 'adresse2', 'code_postal', 'ville', 'email', 'phone', 'phone_mobile', 'fax', 'siret', 'ape', 'active', 'tva', 'is_ttc', 'bio',
        'logo', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'company_type_id'           => 'required',
        'raison_social'             => 'required|is_unique[companies.raison_social,id,{id}]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $searchKtDatatable  = ['raison_social', 'email', 'telephone_fixe'];

    public function __construct()
    {
        parent::__construct();
        $this->builder            = $this->db->table('companies');
        $this->builder_langs       = $this->db->table('companies_langs');
        $this->builder_type       = $this->db->table('companies_type');
        $this->builder_cotisation = $this->db->table('companies_cotisation');
    }

    public function getAllList(int $page, int $perpage, array $sort, array $query)
    {
        $getBaseAllList = $this->getBaseAllList($page, $perpage, $sort, $query, $this->searchKtDatatable);
        if(!empty($getBaseAllList)){
            foreach($getBaseAllList as &$getBase){
                $getBase->companies_type = $this->getCompanyTypeByCompanyTypeId($getBase->company_type_id);
            }
        }
        return $getBaseAllList;
        //print_r($getBaseAllList); exit;
    }

    public static function get_IdCompanyById(string $company_id)
    {
        $db = \Config\Database::connect();
        $company = $db->table('company')->select('company_id')->where(['company_id' => $company_id])->get()->getRow();
        return $company->_company_id;
    }

    public static function getIdCompanyBy_Id($_company_id)
    {
        $db = \Config\Database::connect();
        $company = $db->table('company')->select('company_id')->where(['_company_id' => $_company_id])->get()->getRow();
        return $company->company_id;
    }

    public function getCompanyBy_Id(string $_company_id, $object = true)
    {
        $this->builder->select();
        $this->builder->join('companies_type', 'companies_type.id = companies.company_type_id');
        $this->builder->where(['_company_id' => $_company_id]);
        $company = $this->builder->get();
        if ($object == true)
            return $company->getRow();
        else
            return $company->getRowArray();
    }

    public function getCompanyTypeByCompanyTypeId( int $company_type_id): object
    {
        $this->builder_type->select();
        $this->builder_type->where(['id' => $company_type_id]);
        return $this->builder_type->get()->getRow();
    }


    public function getCompanyType(): array
    {
        $this->builder_type->select();
        $this->builder_type->orderBy('id', 'DESC');
        $companies_type = $this->builder_type->get();
        return $companies_type->getResult();
    }

    public function deleteAllCompany(string $company_id)
    {
        $this->builder->delete([$this->primaryKey => $company_id]);
    }

    /**
     * 
     * 
     */
    public function getCompanyByUUID(string $uuid_company)
    {
        $uuid_company = $this->uuid->fromString($uuid_company)->getBytes();
        $this->builder->where('uuid_company', $uuid_company);
        $user = $this->builder->get()->getRowArray();
        return new Company($user);
    }

    public function getIdCompanyByUUID(string $uuid_company, $full = false)
    {
        $uuid_company = $this->uuid->fromString($uuid_company)->getBytes();
        $this->builder->select($this->primaryKey);
        $this->builder->where('uuid_company', $uuid_company);

        if($full == false){
            return $this->builder->get()->getRow()->{$this->primaryKey};
        }else{
            return $this->builder->get()->getRow();
        }
    }
}
