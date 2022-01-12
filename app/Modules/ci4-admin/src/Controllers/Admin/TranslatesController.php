<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Controllers\BaseAdminController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Models\AuditModel;
use Adnduweb\Ci4Core\Traits\ExportData;
use CodeIgniter\API\ResponseTrait;

class TranslatesController extends BaseAdminController
{

    use ResponseTrait;
    use ExportData;

    /**  @var string  */
    protected $table = "translates";

    /**  @var string  */
    protected $className = "Translates";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = null;

    /** @var bool */
    public $filterDatabase = false;

    /** @var array */
    public $type_export = ['csv'];


    public function __construct(){
        Config('Theme')->layout['header']['display_create'] = false;
    }


    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function index(): string
    {
       
        helper(['array']);

        $this->copyFile();
        
        parent::index();

        $filesCore = array();
        $filesThemesFront = array();
        $charge  = array();

        foreach (glob(APPPATH . "Language/en/*.php") as $filename) {

            if (!preg_match('/^Front_/', basename($filename))) {
                $filesCore[] = basename($filename);
                $charge[strtolower(str_replace('.php', '', basename($filename)))] = include($filename);
            } else {
                $filesThemesFront[] = basename($filename);
                $charge[strtolower(str_replace('.php', '', basename($filename)))] = include($filename);
            }
        }

        $this->viewData['filesCore'] = $filesCore;
        $this->viewData['filesThemesFront'] = $filesThemesFront;

        return $this->render($this->viewPrefix . $this->theme . '/\pages\translate\index', $this->viewData);
    }

    public function getFile()
    {
        
        if ($this->request->isAJAX()) { 
            helper(['array']);

            $response = json_decode($this->request->getBody());

            if ($value = $response->value) {
                $traitement = objectToObject($value);
                if (!empty($traitement->fileCore)) {
                    if (file_exists(ROOTPATH . "app/Language/" . $traitement->lang . "/" . $traitement->fileCore)) {
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileCore);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileCore;
                        $this->viewData['lang']     = $traitement->lang;
                        $viewLangue             = $this->render($this->viewPrefix . $this->theme . '/\pages\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    } else {
                        if (file_exists(ROOTPATH . "app/Language/fr/" . $traitement->fileCore)) {
                            copy(ROOTPATH . "app/Language/fr/" . $traitement->fileCore, ROOTPATH . "app/Language/" . $traitement->lang . "/" . $traitement->fileCore);
                        }
                        if (file_exists(ROOTPATH . "app/Language/en/" . $traitement->fileCore)) {
                            copy(ROOTPATH . "app/Language/en/" . $traitement->fileCore, ROOTPATH . "app/Language/" . $traitement->lang . "/" . $traitement->fileCore);
                        }
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileCore);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileCore;
                        $this->viewData['lang']     = $traitement->lang;
                        $viewLangue             = $this->render($this->viewPrefix . $this->theme . '/\pages\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    }
                } else if (!empty($traitement->fileTheme)) {
                    if (file_exists(APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileTheme)) {
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileTheme);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileTheme;
                        $this->viewData['lang']     = $traitement->lang;
                        $viewLangue             = $this->_render($this->viewPrefix . $this->theme . '/\pages\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    } else {
                        if (file_exists(ROOTPATH . "app/Language/fr/" . $traitement->fileTheme)) {
                            copy(ROOTPATH . "app/Language/fr/" . $traitement->fileTheme, ROOTPATH . "app/Language/" . $traitement->lang . "/" . $traitement->fileTheme);
                        }
                        if (file_exists(ROOTPATH . "app/Language/en/" . $traitement->fileTheme)) {
                            copy(ROOTPATH . "app/Language/en/" . $traitement->fileTheme, ROOTPATH . "app/Language/" . $traitement->lang . "/" . $traitement->fileTheme);
                        }
                        $this->viewData['langue']   = include(APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileTheme);
                        $this->viewData['file']     = APPPATH . "Language/" . $traitement->lang . "/" . $traitement->fileTheme;
                        $this->viewData['lang']     = $traitement->lang;
                        $viewLangue             = $this->_render($this->viewPrefix . $this->theme . '/\pages\translate\viewLangue', $this->viewData);
                        return $this->respond([csrf_token() => csrf_hash(), 'error' => false, 'html' => $viewLangue]);
                    }
                }
            }
        }
    }

    /**
     * Save file
     * 
     */
    public function savefile()
    {

        if ($this->request->isAJAX()) {

            helper(['array']);
            $response = json_decode($this->request->getBody());            

            if ($value = $response->value) {

                $newTraitement = $this->traitement($value);

                //print_r($newTraitement); exit;

                try {
                    save_all_lang_file($newTraitement['file'], $newTraitement['lang'], $newTraitement['trad'], false, true);
                    return $this->getResponse(['success' => lang('Core.success_update')], 200);

                } catch (\Exception $e) {
                    return $this->getResponse(['error' => lang('Core.error_saved_data')], 500);
                }
            }
        }
    }

    /**
     * Delete texte in file
     * 
     */
    public function deleteTexte()
    {
        if ($this->request->isAJAX()) {

            helper(['array']);
            $response = json_decode($this->request->getBody());         

            if ($value = $response->value) {

                $newTraitement = $this->traitement($value);

                try {
                    save_all_lang_file($newTraitement['file'], $newTraitement['lang'], $newTraitement['trad'], false, true);
                    return $this->getResponse(['success' => lang('Core.success_update')], 200);

                } catch (\Exception $e) {
                    return $this->getResponse(['error' => lang('Core.error_saved_data')], 500);
                }
            }
        }
    }

    /**
     * Seach texte in files
     * 
     */
    public function searchTexte()
    {
        if ($this->request->isAJAX()) {

            helper(['array']);

            $response = json_decode($this->request->getBody());        

            if ($value = $response->value) {

                //$newTraitement = $this->traitement($value);


               // if (isset($newTraitement['searchDirect'])) {
                    // SEARCH
                    $this->viewData['searchTextLang'] = search_text_lang($response->value, $response->lang);

                    $viewSearchDirect = $this->render($this->viewPrefix . $this->theme . '/\pages\translate\viewSearchDirect', $this->viewData);
                    return $this->getResponse(['success' => lang('Core.success_update')], 200, ['html' => $viewSearchDirect]);
               // }
            }
        }
    }

    /**
     * Save texte in file
     * 
     */
    public function saveTextfile()
    {
        if ($this->request->isAJAX()) {

             helper(['array']);
             $response = json_decode($this->request->getBody());        

            if ( $value = $response->value ) {

                $newTraitement = $this->traitement($value);
                $firstKey = array_key_first($newTraitement['trad']);
                $fileOrigin = include($newTraitement['file']);
                $oldValue = $fileOrigin[$firstKey];

                helper(['String']);
                if (replaceInfile($newTraitement['file'], $firstKey, $oldValue, $newTraitement['trad'][$firstKey])) {
                    return $this->getResponse(['success' => lang('Core.success_update')], 200);
                } else {
                    return $this->getResponse(['error' => lang('Core.error_saved_data')], 500);
                }
            }
        }
    }


    public function traitement(array $value)
    {
       helper(['array']);

        $newTraitement = [];
        $file = '';
        $lang = '';
        if (!is_array($value)) {
            return false;
        }
        foreach ($value as $k => $v) {

            if (preg_match('`\[(.+)\]`', $v->name, $intro)) {
                if (preg_match("/texte/", $intro[1], $intro2)) {
                    $num = str_replace('][texte', '', $intro[1]);
                    $newTraitement['addTrad'][$num]['texte'] =  $v->value;
                }
                if (preg_match("/value/", $intro[1], $intro2)) {
                    $num = str_replace('][value', '', $intro[1]);
                    $newTraitement['addTrad'][$num]['value'] =  $v->value;
                }
                unset($v->name);
            } else {
                if ($v->name != 'file' && $v->name != 'lang' && $v->name != 'searchDirect') {

                    // On verifie que le token n'est pas dedans
                    if (csrf_token() != $v->name) {
                        // Récupére le name
                        $v->name = str_replace('name|', '', $v->name);
                        $newTraitement['trad'][$v->name] = $v->value;
                    }
                } else {
                    if ($v->name == 'file') {
                        $newTraitement['file'] = $v->value;
                    } else if ($v->name == 'lang') {
                        $newTraitement['lang'] = $v->value;
                    } else {
                        $newTraitement['searchDirect'] = $v->value;
                    }
                }
            }
        }
        if (isset($newTraitement['addTrad'])) {
            foreach ($newTraitement['addTrad'] as $k  => $v) {
                if (!empty($v['texte'])) {
                    $newTraitement['trad'][$v['texte']] = $v['value'];
                }
            }
        }
        return $newTraitement;
    }

    /**
     * Search path natif
     */
    protected function getCoreNatif($lang)
    {

        $loader  = service('autoloader');
        $locator = service('locator');

        $translate = [];

        // Get each namespace
        foreach ($loader->getNamespace() as $namespace => $path) {
            // print_r($namespace); exit;
            if ($namespace != 'Translations' && $namespace != 'CodeIgniter') {

                // Get files under this namespace's "/translate" path
                foreach ($locator->listNamespaceFiles($namespace, '/Language/' . $lang . '/') as $file) {
                    //$translate[] = $file;
                    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                        $pathinfo = (pathinfo($file));
                        // Load the file
                        $translate[$pathinfo['filename']] = $file;
                        //require_once $file;
                    }
                }
            }
        }

        return $translate;
    }


    /**
     * Copy files
     */
    protected function copyFile()
    {

        $temp = [];
        $this->isDir();

        foreach (Config('App')->supportedLocales as $lang) {
            $temp[$lang] = $files = $this->getCoreNatif($lang);

            foreach ($files  as $k => $v) {
                if (!is_file(APPPATH . '/Language/' . $lang . '/' . $k . '.php')) {
                    if (!copy($v, APPPATH . '/Language/' . $lang . '/' . $k . '.php')) {
                        throw new \RuntimeException(lang('Core.noCopyFile', [$k, $lang])  . ' ' . $lang);
                    }
                }
            }
        }

        return true;
    }

    /**
     * Search Dir
     */
    protected function isDir()
    {
        foreach (Config('App')->supportedLocales as $lang) {

            if (!is_dir(APPPATH . '/Language/' . $lang)) {
                mkdir(APPPATH . '/Language/' . $lang, 0777, true);
                //create the index.html file
                if (!is_file(APPPATH . '/Language/' . $lang . '/index.html')) {
                    $file = fopen(APPPATH . '/Language/' . $lang . '/index.html', 'x+');
                    fclose($file);
                }
            }
        }
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

        if(!$response->format || !$response->fileTranslate ){
            return $this->getResponse(['error' => lang('Core.not_choice')], 422);
            exit;
        }

        // ON définit le header et les données pour $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
        $this->headerExport = [0 => 'name', 1 => 'value'];
        $file = include($response->fileTranslate);
        $content = [];
        foreach($file as $k => $v){
            $content[] = ['name' => $k, 'value' => $v];
        }
        $this->dataExport = $content;

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

    /**
     * Export the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function import($format = null)
    {
        $file          = $this->request->getFile('file');
        $fileTranslate = $this->request->getPost('fileTranslate');

        // image validation
        $validated = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file, '.implode(',', Config('Mimes')::$mimes['csv']).']',
                'max_size[file,4096]',
            ],
        ]);

        if (!$validated) {
            //return $this->getResponse(['error' =>  $this->validator], 500);
            return $this->getResponse(['error' =>  $file->getErrorString() . '(' . $file->getError() . ')'], 500);
        }

        $chunkDir = WRITEPATH . 'uploads/';
       
        // Generate a new secure name
        $name = $file->getRandomName();

        // Move the file
        try{

            $file->move($chunkDir, $name);
            
        }catch (HTTPException $e){

            log_message('error', $e->getMessage());
            return $this->getResponse(['error' => $e->getMessage()], 400);
            
        }

        // Trigger the Event with the new File
        Events::trigger('upload', $file);
        
        // On ouvre el fichier
        $file = fopen($chunkDir . $name, "r");
        $collection = [];
        $i = 0;
        while (($filedata = fgetcsv($file, 1500, ",")) !== FALSE) {
            if($i > 0 ){ 
                $collection['trad'][$filedata[0]] = $filedata[1];
            }
            $i++;
        }

        $langExplode = str_replace(APPPATH . "Language/", '',  $this->request->getPost('fileTranslate'));
        list($lang, $file) = explode('/', $langExplode);


        try {
            save_all_lang_file($fileTranslate, $lang, $collection['trad'], false, true);
            return $this->getResponse(['success' => lang('Core.success_update')], 200);

        } catch (\Exception $e) {
            return $this->getResponse(['error' => lang('Core.error_saved_data')], 500);
        }

        print_r($collection); exit;
       
        @unlink($chunkDir . $name);
        return $this->getResponse(['success' => lang('Core.download_file')], 200);
       
    }
}
