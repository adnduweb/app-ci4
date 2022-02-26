<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Controllers\BaseAdminController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Core\Libraries\Logs;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Models\AuditModel;
use Adnduweb\Ci4Core\Traits\ExportData;
use CodeIgniter\API\ResponseTrait;


class LogsController extends BaseAdminController
{

    use ResponseTrait;
    use ExportData;

    /**  @var string  */
    protected $table = "logs";

    /**  @var string  */
    protected $className = "Log";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced'; 

    /**  @var object  */
    public $tableModel = AuditModel::class;

    /**  @var string  */
    public $identifier_name = 'id'; 

    /** @var bool */
    public $filterDatabase = false;

    protected $logsPath   = WRITEPATH . 'logs/';
    
    protected $logsLimit = '20';


    public function __construct(){
        helper('filesystem');
        Config('Theme')->layout['header']['display_create'] = false;
        $this->logsHandler = new Logs();
    }


    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function index(): string
    {
       
        Theme::add_js('plugins/custom/datatables/datatables.bundle.js');
        parent::index();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\logs\index', $this->viewData);
    }


    public function initPageHeaderToolbar()
    {

        if ($this->display == 'index' || $this->display == 'indexTraffics' || $this->display == 'indexConnexions') {

            $this->page_header_toolbar_btn['list-files'] = [
                'short' => 'ListFiles',
                'color' => 'primary',
                'href' => route_to('log-list-files'),
                'desc' => lang('Core.Files'),
                'svg'   => service('theme')->getSVG("icons/duotone/Home/Earth.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                'force_desc' => true,
            ];


            $this->page_header_toolbar_btn['list-system'] = [
                'short' => 'ListSystem',
                'color' => 'primary',
                'href' => route_to('logs'),
                'desc' => lang('Core.system'),
                'svg'   => service('theme')->getSVG("icons/duotone/Home/Earth.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                'force_desc' => true,
            ];

            $this->page_header_toolbar_btn['list-traffics'] = [
                'short' => 'ListTraffics',
                'color' => 'primary',
                'href' => route_to('log-list-traffics'),
                'desc' => lang('Core.traffic'),
                'svg'   => service('theme')->getSVG("icons/duotone/Home/Earth.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                'force_desc' => true,
            ];

            $this->page_header_toolbar_btn['list-connexions'] = [
                'short' => 'ListConnexions',
                'color' => 'primary',
                'href' => route_to('log-list-connexions'),
                'desc' => lang('Core.Connexions'),
                'svg'   => service('theme')->getSVG("icons/duotone/Home/Earth.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                'force_desc' => true,
            ];
        }
        parent::initPageHeaderToolbar();
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

        if ($this->request->isAJAX()) {
            $response = json_decode($this->request->getBody());

            if(!is_array($response->id))
                return false; 

            if ($ids = $response->id) 
            {
                if (!empty($ids)) 
                {
                    foreach ($ids as $id) 
                    {
                        switch ($response->action) {
                            case 'log':
                                $this->tableModel->delete($id);
                                break;
                            case 'traffic':
                                model(\Adnduweb\Ci4Core\Models\VisitModel::class)->delete($id);
                                break;
                            case "connexion":
                                model(LoginModel::class)->delete($id);
                                break;
                        }
                       
                    }
                    return $this->getResponse(['success' => lang('Core.your_selected_records_have_been_deleted')], 200);
                }
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

        // ON définit le header et les données pour $header = array_merge(model(AuditModel::class)::$orderable, ['created_at']);
      

        switch ($response->display) {
            case 'index':
                $this->headerExport = array_merge(model(AuditModel::class)::$orderable, ['created_at']);
                $this->dataExport = model(AuditModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();
                break;
            case 'indexTraffics':
                $this->headerExport = array_merge(model(\Adnduweb\Ci4Core\Models\VisitModel::class)::$orderable, ['created_at']);
                $this->dataExport = model(\Adnduweb\Ci4Core\Models\VisitModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();
                break;
            case 'indexConnexions':
                $this->headerExport = array_merge(model(LoginModel::class)::$orderable);
                $this->dataExport = model(LoginModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();
                break;
        }

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

                    $this->viewData['header'] = $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;

                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/pdf;base64,".base64_encode($exportPdf->output())]);
                    exit;


                }else{
                    $this->viewData['header'] = $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;
                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', false);
                    exit;
                }
    
                break;
            default:
                $response = ['code' => 200, 'message' => lang('Core.not_choice'), 'success' => true, csrf_token() => csrf_hash()];
                return $this->respond($response, 200);
        }
       
    }
    

    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function indexTraffics(): string
    {
       
        Theme::add_js('plugins/custom/datatables/datatables.bundle.js');
        parent::index();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\logs\index_traffic', $this->viewData);
    }

    /**
     * Function datatable.
     *
     * @return CodeIgniter\Http\Response
     */
    public function ajaxDatatableTraffics(): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search[value]');
            $order = model(\Adnduweb\Ci4Core\Models\VisitModel::class)::ORDERABLE[$this->request->getVar('order[0][column]')];
            $dir = $this->request->getVar('order[0][dir]');

           return $this
            ->response
            ->setStatusCode(200)
            ->setJSON([
                'draw'            => $this->request->getVar('draw'),
                'recordsTotal'    =>  model(\Adnduweb\Ci4Core\Models\VisitModel::class)->getResource()->countAllResults(),
                'recordsFiltered' =>  model(\Adnduweb\Ci4Core\Models\VisitModel::class)->getResource($search)->countAllResults(),
                'data'            =>  model(\Adnduweb\Ci4Core\Models\VisitModel::class)->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject(),
                'token'           => csrf_hash()
            ]);

        }

        return $this->getResponse(['success' => lang('Core.no_content')], 204);
    }

     /**
     * Displays a list of available.
     *
     * @return string
     */
    public function indexConnexions(): string
    {
       
        Theme::add_js('plugins/custom/datatables/datatables.bundle.js');
        parent::index();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\logs\index_connexion', $this->viewData);
    }

        /**
     * Function datatable.
     *
     * @return CodeIgniter\Http\Response
     */
    public function ajaxDatatableConnexions(): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search[value]');
            $order = model(LoginModel::class)::ORDERABLE[$this->request->getVar('order[0][column]')];
            $dir = $this->request->getVar('order[0][dir]');

           return $this
            ->response
            ->setStatusCode(200)
            ->setJSON([
                'draw'            => $this->request->getVar('draw'),
                'recordsTotal'    => model(LoginModel::class)->getResource()->countAllResults(),
                'recordsFiltered' => model(LoginModel::class)->getResource($search)->countAllResults(),
                'data'            => model(LoginModel::class)->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject(),
                'token'           => csrf_hash()
            ]);

        }

        return $this->getResponse(['success' => lang('Core.no_content')], 204);
    }

      /**
     * Displays a list of available.
     *
     * @return string
     */
    public function indexFiles(): string
    {
        parent::index();
        // Load the Log Files.
         $this->viewData['logs'] = get_filenames($this->logsPath);


        unset( $this->viewData['logs'][0]);

        $this->viewData['result'] = $this->logsHandler->paginateLogs( $this->viewData['logs'], $this->logsLimit);
        $this->viewData['pager'] = $this->viewData['result']['pager'];
        //print_r( $viewData['logs']); exit;
        return $this->render($this->viewPrefix . $this->theme . '/\pages\logs\index_files', $this->viewData);
    }

    public function viewsFiles(string $file){
        helper('security');
        $file = sanitize_filename($file);

        if (empty($file) || ! file_exists($this->logsPath . $file)) {
            Theme::set_message('error', lang('Logs.empty'), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        $logs = $this->logsHandler->processFileLogs($this->logsPath . $file);

        $result = $this->logsHandler->paginateLogs($logs, $this->logsLimit);

         $this->viewData['logFile']       = $file;
         $this->viewData['canDelete']     = 1;
         $this->viewData['logContent']    = $result['logs'];
         $this->viewData['pager']         = $result['pager'];
         $this->viewData['logFilePretty'] = date('F j, Y', strtotime(str_replace('.log', '', str_replace('log-', '', $file))));

        return $this->render($this->viewPrefix . $this->theme . '/\pages\logs\view_log', $this->viewData);
    }

       /**
     * Delete the specified log file or all.
     *
     * @return RedirectResponse
     */
    public function deleteLog()
    {
        $delete    = $this->request->getPost('delete');
        $deleteAll = $this->request->getPost('delete_all');

        if (empty($delete) && empty($deleteAll)) {
            return redirect()->to('log-views-files')->with(
                'error',
                lang('Core.resourcesNotFound', ['logs'])
            );
        }

        if (! empty($delete)) {
            helper('security');

            $checked    = $_POST['checked'];
            $numChecked = count($checked);

            if (is_array($checked) && $numChecked) {
                foreach ($checked as $file) {
                    @unlink($this->logsPath . sanitize_filename($file));
                }
                Theme::set_message('success', lang('Core.saved_data'), lang('Logs.delete_success'));
                return redirect()->route('log-list-files');
            }
        }

        if (! empty($deleteAll)) {
            if (delete_files($this->logsPath)) {
                // Restore the index.html file.
                @copy(APPPATH . '/index.html', "{$this->logsPath}index.html");

                Theme::set_message('success', lang('Core.saved_data'), lang('Logs.delete_all_success'));
                return redirect()->route('log-list-files');
            }

            Theme::set_message('error', lang('Logs.delete_error'));
            return redirect()->route('log-list-files')->with('error', lang('Logs.delete_error'));
        }

        Theme::set_message('error', lang('Core.unknownAction'));
        return redirect()->route('log-list-files');
    }

}
