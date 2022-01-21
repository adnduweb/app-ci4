<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Entities\Module;
use Adnduweb\Ci4Core\Models\ModuleModel;
use Adnduweb\Ci4Admin\Models\PermissionModel;
use CodeIgniter\API\ResponseTrait;

class ModulesController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**  @var string  */
    protected $table = 'modules';

    /**  @var string  */
    protected $className = 'Module';

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = '';

    /**  @var object  */
    public $tableModel = ModuleModel::class;

    public $module;

    public function __construct(){
        $this->module = service('module');
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

        // print_r($this->module->listModules()); exit;

        // $this->viewData['modules'] = $this->module->listModule();
        $this->viewData['modules'] = $this->module->listModules();

       //print_r($this->viewData['modules']); exit;


        return $this->render($this->viewPrefix . $this->theme . '/\pages\modules\index', $this->viewData);
    }

    public function listModule(){
       
        // Add this to Footer, Including all module routes
        $modules_path = APPPATH . 'Modules/';
        $modules = scandir($modules_path);

        foreach ($modules as $module) {
            if ($module === '.' || $module === '..' || $module === '.DS_Store') {
                continue;
            }

            if (is_dir($modules_path) . '/' . $module) {
                $this->modules[] = [
                    'path' => $modules_path . $module,
                    'name' => strtolower($module)
                ];
                
            }
        }
    }

    /**
     * Update item details. https://www.positronx.io/codeigniter-rest-api-tutorial-with-example/
     * 
     *
     * @return RedirectResponse
     */
    public function updateAjax(): ResponseInterface
    {

       $module = $this->request->getJSON();    
       //print_r($module); exit;

       $moduleInstance = model(ModuleModel::class)->getModuleByHandle($module->handle);
       //print_r($moduleInstance); exit;
    
       if(empty($moduleInstance)){
            $module->name =  str_replace('-', ' ', $module->handle);
            $module->class =  $module->class;
            $module->is_installed =  1;
            list(, $config) = explode('-', $module->handle);

            // ON regarde dans le composer du module
             $fileComposer = $this->module->getComposer(APPPATH . 'Modules/'.  $module->handle);
             $namespace = array_key_first($fileComposer['autoload']['psr-4']);
             $namespace = rtrim($namespace, "\/");

            if(!model(ModuleModel::class)->save( $module)){
                return $this->failure(400, 'No module save', true);
            }

            //create permissions
            $createPermissions = config(ucfirst($config))->createPermissions();
            model(PermissionModel::class)->createPermissions($createPermissions);
    
            return $this->getResponse(['success' => 'Module updated successfully'], 200);
       }else{
        if(!model(ModuleModel::class)->delete($moduleInstance->id)){
            return $this->failure(400, 'No module save', true);
        }

        return $this->getResponse(['success' => 'Module deleted successfully'], 200);
       }
    }

        /**
     * Update item details. https://www.positronx.io/codeigniter-rest-api-tutorial-with-example/
     * 
     *
     * @return RedirectResponse
     */
    public function syncBDD(): ResponseInterface
    {

       $module = $this->request->getJSON();    

       $moduleInstance = model(ModuleModel::class)->find($module->id);
    
       if(!empty($moduleInstance)){


            $migrate = \Config\Services::migrations();

            try
            {
                $migrate->setNamespace($moduleInstance->class)->latest();
            }
            catch (\Throwable $e)
            {
                return $this->getResponse(['error' =>  $e->getMessage()], 500);
            }

            return $this->getResponse(['success' => command('migrate status ')], 200);
       }else{
        return $this->getResponse(['error' => 'Sync not successfully'], 500);
       }
        
    }
}
