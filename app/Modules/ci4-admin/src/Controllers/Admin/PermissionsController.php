<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\Permission;
use Adnduweb\Ci4Admin\Models\PermissionModel;
use Adnduweb\Ci4Core\Traits\ExportData;
use CodeIgniter\API\ResponseTrait;

class PermissionsController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;
    use ExportData;

    /**  @var string  */
    protected $table = "permissions";

    /**  @var string  */
    protected $className = "Permission";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = PermissionModel::class;

    /**  @var string  */
    public $identifier_name = 'name'; 

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

        return $this->render($this->viewPrefix . $this->theme . '/\pages\permissions\index', $this->viewData);
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
//             $order = PermissionModel::ORDERABLE[$this->request->getVar('order[0][column]')];
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

        //$this->display_notice();

        helper(['tools']);

        $this->viewData['title_detail'] =  $this->object->name  . ' - ' .  $this->object->description;
        $this->viewData['form'] = $this->object;

        return $this->render($this->viewPrefix . $this->theme . '/\pages\permissions\form', $this->viewData);

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
        $this->viewData['form'] = new Permission();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\permissions\form', $this->viewData);
    }

    /**
     * Creates a item from the new form data.
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {

        // validate
        $permissions = new PermissionModel();
        $this->rules = [
            'name'              => 'required',
            'description'     => 'required',
        ];
        if (!$this->validate($this->rules)) {
            Theme::set_message('error', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        $name = $this->request->getPost('name');
        if (!stristr($this->request->getPost('name'), '.')) {
           Theme::set_message('error', lang('Core.mauvais_formattage_name'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Try to create the item
        $permission = $this->request->getPost();
        if (! $permissionId = model(PermissionModel::class)->insert($permission, true)) {
            Theme::set_message('error', model(PermissionModel::class)->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

    
          // Success!
          Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
          return redirect()->to($this->path_redirect . '/edit/' . $permissionId  . '?token=' . $this->token );

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

        if (!stristr($this->request->getPost('name'), '.')) {
           Theme::set_message('error', lang('Core.mauvais_formattage_name'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // try to update the item
        $permission = $this->request->getPost();
        if (! model(PermissionModel::class)->update($this->id, $permission)) {
            Theme::set_message('error', model(PermissionModel::class)->errors(), lang('Core.warning_error'));
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
                $isNatif = false;
                foreach ($response->id as $key => $id) {

                    $isNatif = PermissionModel::getNatifById($id);

                    if($isNatif == '1'){
                        $isNatif = true;
                        break;
                    }

                    $this->tableModel->delete(['id' => $id]);
                }

                if ($isNatif == true) {
                    return $this->getResponse(['error' => lang('Core.not_delete_perm_natif')], 401);
                } else {
                    return $this->getResponse(['success' => lang('Core.your_selected_records_have_been_deleted')], 200);
                }
        
        }
        return $this->respondNoContent();
       
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

        // ON définit le header et les données pour $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
        $this->headerExport = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
        $this->dataExport = model(PermissionModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();

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

                    $this->viewData['header'] =  $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;

                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/pdf;base64,".base64_encode($exportPdf->output())]);
                    exit;


                }else{
                    $this->viewData['header'] =  $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;
                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', false);
                    exit;
                }
    
                break;
            default:
                $response = ['code' => 204, 'message' => lang('Core.not_choice'), 'success' => true, csrf_token() => csrf_hash()];
                return $this->respond($response, 204, 'pas content');
        }
       
    }

    public function display_notice(){
        $this->notice = [
            'type' =>'primary', 
            'icon' =>'duotune/general/gen044.svg', 
            'texte' =>lang('Core.Updating customer details will receive a privacy audit. For more info, please read our<a href="#">Privacy Policy</a>')];

            $this->viewData['notice'] =  $this->notice; 
    }

}
