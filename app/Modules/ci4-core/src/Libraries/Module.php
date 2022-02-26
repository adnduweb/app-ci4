<?php

namespace Adnduweb\Ci4Core\Libraries;
use Adnduweb\Ci4Core\Models\ModuleModel;

class Module
{

    private $items = [];

    private $modules = [];

    public function __construct()
    {
        $this->listModules();
    }

    public function listPathModule(){
       
        // Add this to Footer, Including all module routes
        $modules_path = APPPATH . 'Modules/';
        $modules = scandir($modules_path);

        //print_r(service('autoloader')->getNamespace()); exit;

        foreach ($modules as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            

            if (is_dir($modules_path) . '/' . $module && $module != '.DS_Store') {

                $class = '';
                foreach( service('autoloader')->getNamespace() as $k => $namespace ){
                    if($namespace[0] == APPPATH . 'Modules/'. $module . '/src/'){
                        $class = $k;
                    }
                }

                list($one, $two) = explode('-', $module);
                $this->items[strtolower($module)] = (object)[
                    'path'         => $modules_path . $module,
                    'class'        => $class,
                    'name'         => strtolower(str_replace('-', '', $module)),
                    'handle'       => strtolower($module),
                    'is_natif'     => (property_exists(config(ucfirst($two)), 'natif')) ? 1 : 0,
                    'is_installed' => 0,
                    'active'       => 0
                ];
                
            }
        }
        return $this->items;
    }


    public function isEnabled(){
       
       $this->modules['enabled'] = model(ModuleModel::class)->where('is_installed', 1)->findAll();

       return $this->modules['enabled'];

    }

    public function isUnenable(){
       
        $this->modules['unenabled'] = model(ModuleModel::class)->where('is_installed', 0)->findAll();

        // ON regarde si on n'a pas de module en cours : App/modules/...
        $this->listPathModule();
        $this->isEnabled();
        $unenabled = [];
        $i = 0;
        foreach($this->modules['enabled'] as $module){
            if($this->items[$module->handle]){
               unset($this->items[$module->handle]);
            }
            $i++;
        }

        $this->modules['unenabled'] = $this->items;

        return $this->modules['unenabled'];
     }

     public function listModules(){

        $this->modules['unenabled'] = model(ModuleModel::class)->where('is_installed', 0)->findAll();

        // ON regarde si on n'a pas de module en cours : App/modules/...
        $this->listPathModule();
        $this->isEnabled();
        $unenabled = [];
        $i = 0;
        foreach($this->modules['enabled'] as $module){
            if($this->items[$module->handle]){
               unset($this->items[$module->handle]);
            }
            $i++;
        }

        $this->modules['unenabled'] = array_merge($this->modules['unenabled'], $this->items);

        return $this->modules;
     }


     public static function getComposer(string $path)
     {
         $json = file_get_contents($path . '/composer.json');
 
         $composer = json_decode($json, true);
         return $composer;
 
         // return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/dependencies', $dependencies);
     }

}