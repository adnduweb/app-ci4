<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Group;
use Adnduweb\Ci4Admin\Models\GroupModel;
use Adnduweb\Ci4Core\Traits\ExportData;
use CodeIgniter\API\ResponseTrait;

class GroupsController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;
    use ExportData;

    /**  @var string  */
    protected $table = "groups";

    /**  @var string  */
    protected $className = "Group";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = GroupModel::class;

    /**  @var string  */
    public $identifier_name = 'name';

     /**  @var array  */
    public $groupIdRestriction = [1, 2, 3];

    /** @var bool */
    public $filterDatabase = false;

    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function index(): string
    {
        Theme::add_js('plugins/custom/datatables/datatables.bundle.js');
        parent::index();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\groups\index', $this->viewData);
    }

//    /**
//      * Function datatable.
//      *
//      * @return CodeIgniter\Http\Response
//      */
//     public function ajaxDatatable()
//     {
//         if ($this->request->isAJAX()) {
//             $start = $this->request->getVar('start');
//             $length = $this->request->getVar('length');
//             $search = $this->request->getVar('search[value]');
//             $order = GroupModel::ORDERABLE[$this->request->getVar('order[0][column]')];
//             $dir = $this->request->getVar('order[0][dir]');

//             return $this->respond([
//                 'draw'            => $this->request->getVar('draw'),
//                 'recordsTotal'    => $this->tableModel->getResource()->countAllResults(),
//                 'recordsFiltered' => $this->tableModel->getResource($search)->countAllResults(),
//                 'data'            => $this->tableModel->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject(),
//                 'token'           => csrf_hash()
//             ]);
//         }

//         return $this->respondNoContent();
//     }

    /**
     * Shows details for one item.
     *
     * @param string $itemId
     *
     * @return string
     */
    public function edit(string $id): string
    {
        parent::edit($id);

        helper(['tools']);

        $this->viewData['title_detail'] =  $this->object->name  . ' - ' .  $this->object->description;
        $this->viewData['form'] = $this->object;

        // Super Admin Whououuuu
        if ($id == '1') {
            $this->viewData['permissions'] = '';
        } else {
             //Get Permissions Group
            $permissionModel               = new \Adnduweb\Ci4Admin\Models\PermissionModel();
            $permissionByIdGroupGroup       = $permissionModel->getPermissionsByIdGroup($this->id);
            $this->viewData['permissionByIdGroupGroup'] = [];
            if (!empty($permissionByIdGroupGroup)) {
                foreach ($permissionByIdGroupGroup as $permissions) {
                    $this->viewData['permissionByIdGroupGroup'][$permissions->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
            $this->viewData['permissions'] = $permissionModel->getPermission();
        }


        return $this->render($this->viewPrefix . $this->theme . '/\pages\groups\form', $this->viewData);

    }

        /**
     * Displays the form for a new item.
     *
     * @return string
     */
    public function new(): string
    {
        helper('tools');
       //parent::create();

        // Initialize form
        $this->viewData['form'] = new Group();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\groups\form', $this->viewData);
    }

    /**
     * Creates a item from the new form data.
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {

        // validate
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('error', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the item
        $group = $this->request->getPost();
        if (! $groupId = model(GroupModel::class)->insert($group, true)) {
            Theme::set_message('error', model(GroupModel::class)->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

    
          // Success!
          Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
          return redirect()->to($this->path_redirect . '/edit/' . $groupId  . '?token=' . $this->token );

    }

   /**
     * Update item details.
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function update( string $id): RedirectResponse
    {
        // validate
        $this->rules = [
            'name'        => 'required',
            'description' => 'required',
        ];

        if (!$this->validate($this->rules)) {
            Theme::set_message('error', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }


        // try to update the item
        $group = $this->request->getPost();
        if (! model(GroupModel::class)->update($this->id, $group)) {
            Theme::set_message('error', model(GroupModel::class)->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }


         // Success!
         Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
         return redirect()->to($this->path_redirect . '/edit/' . $this->id);


    }

        /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function delete() : ResponseInterface
    {

        //print_r($this->request->getRawInput('id')); exit;

        if ($this->request->isAJAX()) {

              //$ids = $this->request->getRawInput('id');
              $response = json_decode($this->request->getBody());
              //print_r($response); exit;
              if(!is_array($response->id))
                  return false; 

                //print_r($rawInput['id']); exit;
                $comptePrincipal = false;
                foreach ($response->id as $key => $id) {

                    if(in_array($id, $this->groupIdRestriction)){
                        $comptePrincipal = true;
                        break;
                    }

                    $this->tableModel->delete(['id' => $id]);
                }

                if ($comptePrincipal == true) {
                    return $this->getResponse(['error' => lang('Core.not_delete_perm_natif')], 401);
                } else {
                    return $this->getResponse(['success' => lang('Core.your_selected_records_have_been_deleted')], 200);
                }
        
        }
        return $this->respondNoContent();
       
    }
    /**
     * Save Permission item .
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function savePermissions() : ResponseInterface
    {
        if ($this->request->isAJAX()) 
        {
            $response = json_decode($this->request->getBody());
            if ($response->value)
             {
                $details = explode('|', $response->value);

                if ($response->crud == 'add') 
                {
                    $this->tableModel->addPermissionToGroup($details[1], $details[0]);

                } 
                else 
                {
                    $this->tableModel->removePermissionFromGroup($details[1], $details[0]);
                }

                return $this->getResponse(['success' => lang('Core.saved_data')], 200);
            }
        }
    }

    public function saveAllPermissions()
    {
        if ($this->request->isAJAX()) {
            
            $response = json_decode($this->request->getBody());

            if ($response->value){

                if ($response->crud == 'add') {

                    $add = false;
                    foreach ($response->value as $val) {

                        $details = explode('|', $val);
                        $this->tableModel->addPermissionToGroup($details[1], $details[0]);
                        if (!isset($this->tableModel->resultID->num_rows)) {
                            $add = true;
                        }
                    }

                    if ($add == true) {
                         return $this->getResponse(['success' => lang('Core.saved_data')], 200);
                    }
                } else {
                    foreach ($response->value as $val) {
                        $details = explode('|', $val);
                        $this->tableModel->removePermissionFromGroup($details[1], $details[0]);
                    }
                    return $this->getResponse(['success' => lang('Core.saved_data')], 200);
                }
            }
        }
    }


    public function saveAllPermissionsUsers()
    {
        if ($this->request->isAJAX()) {

            $response = json_decode($this->request->getBody());

            $value  = $response->value;
            $crud  = $response->crud;

            $details = explode('|', $value);
            if ($crud == 'add') {
                model(\Adnduweb\Ci4Admin\Models\PermissionModel::class)->addPermissionToUser($details[1], $details[0]);
            } else {
                model(\Adnduweb\Ci4Admin\Models\PermissionModel::class)->removePermissionFromUser($details[1], $details[0]);
            }
            return $this->getResponse(['success' => lang('Core.data_save')], 200);
        }
        return $this->getResponse(['success' => lang('Core.no_content')], 204);
    }

    /**
     * Export the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function export($format = null)
    {

        //https://onlinewebtutorblog.com/export-data-into-excel-report-in-codeigniter-4-tutorial/
        $response = json_decode($this->request->getBody());

        if(!$response->format){
            return $this->getResponse(['error' => lang('Core.not_choice')], 422);
            exit;
        }


        // ON définit le header et les données pour $header = array_merge(model(GroupModel::class)::$orderable, ['created_at']);
        $this->headerExport = array_merge(model(GroupModel::class)::$orderable, ['created_at']);
        $this->dataExport = model(GroupModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();

        switch ($response->format) {
            case 'excel':
                if ($this->request->isAJAX()) {
                    $exportXls  = $this->exportXls($this->className, strtolower($this->className).'-'.time().'.xlsx', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/vnd.ms-excel;base64,".base64_encode($exportXls)]);
                }else{
                    $exportXls  = $this->exportXls($this->className, strtolower($this->className).'-'.time().'.xlsx', false);
                    exit;
                } 
                
                break;
            case 'csv':
                if ($this->request->isAJAX()) {
                    $exportCsv  = $this->exportCsv('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/csv;base64,".base64_encode($exportCsv)]);
                    exit;
                }else{
                    $exportCsv  = $this->exportCsv('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv', false);
                    exit;
                }
                break;
            case 'pdf':
                if ($this->request->isAJAX()) {

                    $this->viewData['header'] = array_merge(model(GroupModel::class)::$orderable, ['created_at']);
                    $this->viewData['data'] = model(GroupModel::class)->asArray()->select(implode(',', $this->viewData['header']))->findAll();

                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/pdf;base64,".base64_encode($exportPdf->output())]);
                    exit;
                }else{
                    $this->viewData['header'] = array_merge(model(GroupModel::class)::$orderable, ['created_at']);
                    $this->viewData['data'] = model(GroupModel::class)->asArray()->select(implode(',', $this->viewData['header']))->findAll();
                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', false);
                    exit;
                }
                break;
            default:
                $response = ['code' => 200, 'message' => lang('Core.not_choice'), 'success' => true, csrf_token() => csrf_hash()];
                return $this->respond($response, 200);
        }
       
    }
}
