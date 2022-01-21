<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use \Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Core\Models\LanguageModel;
use Adnduweb\Ci4Core\Models\CurrencyModel;
use Adnduweb\Ci4Core\Models\SettingModel;
use CodeIgniter\API\ResponseTrait;

class SettingsController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;


    /**  @var string  */
    protected $table = "settings";

    /**  @var string  */
    protected $className = "Setting";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = null;

    /**  @var string  */
    public $identifier_name = 'lastname';


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
        Theme::delHtmlClass('content-container');
        Theme::addHtmlClass('content-container', 'container-fluid');

        $this->viewData['form'] =  service('settings');

        parent::index();

        $this->viewData['getThemesAdmin'] = $this->getThemesAdmin();
        $this->viewData['getThemesFront'] = $this->getThemesFront();
        $this->viewData['languages']      = (new LanguageModel())->select('id, name, iso_code')->where('active', 1)->get()->getResult();
        $this->viewData['countList']      = [];
        $this->viewData['action'] = 'edit';
        $this->viewData['title_detail']  = '';

        return $this->render($this->viewPrefix . $this->theme .'/\pages\settings\index', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        if ($this->request->getPost('user')) {
            $user = $this->request->getPost('user');
            foreach ($user as $k => $v) {
                //$this->tableModel->getExist($k, 'user', $v);
                service('settings')->{$k} = $v;
            }
        }

        //print_r($this->request->getPost());exit;
        if ($core =  $this->request->getPost('core')) {

            (!isset($core['maintenance']))      ? $core['maintenance']      = 0 :  $core['maintenance']      = true;
            (!isset($core['displayFront']))     ? $core['displayFront']     = 0 :  $core['displayFront']     = true;
            (!isset($core['displayEcommerce'])) ? $core['displayEcommerce'] = 0 :  $core['displayEcommerce'] = true;
            (!isset($core['addSignature']))     ? $core['addSignature']     = 0 :  $core['addSignature']     = true;
            (!isset($core['manifest']))         ? $core['manifest']         = 0 :  $core['manifest']         = true;
            (!isset($core['servicesWworkers'])) ? $core['servicesWworkers'] = 0 :  $core['servicesWworkers'] = true;

            foreach ($core as $k => $v) {
                
                service('settings')->set('App.core', $v, $k);
            }
        }

        if ($theme_fo = $this->request->getPost('theme_fo')) {

            if(!empty($theme_fo)){
                foreach ($theme_fo as $k => $v) {
                    service('settings')->set('App.theme_fo', $v, $k);
                }
            }
        }

        if ($language_bo = $this->request->getPost('language_bo')) {
                (!isset($language_bo['multilangue']))   ? $language_bo['multilangue']   = 0 :  $language_bo['multilangue']   = true;

                if(!empty($language_bo)){
                    foreach ($language_bo as $k => $v) {
                        service('settings')->set('App.language_bo', $v, $k);
                    }
                }
        }

        if ($theme_bo = $this->request->getPost('theme_bo')) {
           
            if(!empty($theme_bo)){
                foreach ($theme_bo as $k => $v) {
                    service('settings')->set('App.theme_bo', $v, $k);
                }
            }
        }


        $this->activateManifest(); // activate manifest
        $this->activateServicesWorkers(); // Activate Service Workers

        // Success!
        Theme::set_message('success', lang('Core.save_data'), lang('Core.cool_success'));

        //echo '/' . CI_AREA_ADMIN . '/' . $this->category . '/' . $this->table; exit;
        return redirect()->to('/' . CI_AREA_ADMIN . '/' . $this->category . '/' . $this->table)->with('success', lang('Users.newWorkflowSuccess'));

    }



    public function getThemesAdmin()
    {
        $dirTheme = [];
        foreach (glob(ROOTPATH . '/public/backend/themes/*', GLOB_ONLYDIR) as $dir) {
            $dirTheme[] = basename($dir);
        }
        return $dirTheme;
    }

    public function getThemesFront()
    {

        if(empty($dirTheme)){
            foreach (glob(ROOTPATH . '/public/frontend/themes/*', GLOB_ONLYDIR) as $dir) {
                $dirTheme[] = basename($dir);
            }
        }

        return $dirTheme;
    }

    protected function activateManifest(){

        if(service('settings')->get('App.theme_fo', 'manifest') == true){
         
            if ( ! write_file(ROOTPATH . 'public/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/manifest.json', $this->getManifest())){
                    throw new \Exception(lang('Core.Unable to write the file'));
            }

        }else{
            @unlink(ROOTPATH . 'public/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/manifest.json');
        }
        
    }

    protected function getManifest(){
        return '{
            "name": "'.service('settings')->get('App.theme_bo', 'naneApp').'",
            "short_name": "'.service('settings')->get('App.theme_bo', 'naneShortApp').'",
            "description": "'.service('settings')->get('App.theme_bo', 'descApp').'",
            "icons": [{
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-36x36.png",
                    "sizes": "36x36",
                    "type": "image\/png",
                    "density": "0.75"
                },
                {
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-48x48.png",
                    "sizes": "48x48",
                    "type": "image\/png",
                    "density": "1.0"
                },
                {
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-72x72.png",
                    "sizes": "72x72",
                    "type": "image\/png",
                    "density": "1.5"
                },
                {
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-96x96.png",
                    "sizes": "96x96",
                    "type": "image\/png",
                    "density": "2.0"
                },
                {
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-144x144.png",
                    "sizes": "144x144",
                    "type": "image\/png",
                    "density": "3.0"
                },
                {
                    "src": "/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/android-icon-192x192.png",
                    "sizes": "192x192",
                    "type": "image\/png",
                    "density": "4.0"
                }
            ],
            "start_url": "'.base_url().'",
            "theme_color": "#1B1B28",
            "background_color": "#F1F2F7",
            "scope": "'.base_url().'",
            "display": "standalone"
        }';
    }

    protected function activateServicesWorkers(){
        if(service('settings')->get('App.theme_fo', 'servicesWworkers') == true){
         
            if ( ! write_file(ROOTPATH . 'public/service-worker.js', $this->getServicesWorkers())){
                    throw new \Exception(lang('Core.Unable to write the file'));
            }
        }else{
            @unlink(ROOTPATH . 'public/service-worker.js');
        }
    }

    protected function getServicesWorkers(){

        return "
                var cacheName = 'spreadaurora_prod-v1';
                var appShellFiles = [
                    '/',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/plugins/global/plugins.bundle.js',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/plugins/custom/prismjs/prismjs.bundle.js',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/plugins/custom/fullcalendar/fullcalendar.bundle.css',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/plugins/global/plugins.bundle.css',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/plugins/custom/prismjs/prismjs.bundle.css',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/".ENVIRONMENT."/css/style.bundle.css',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/language/lang_fr.js',
                    '/backend/themes/". service('settings')->get('App.theme_bo', 'name') ."/favicons/favicon.ico'
                ];

                self.addEventListener('install', (e) => {
                    console.log('[Service Worker] Installation');
                    e.waitUntil(
                        caches.open(cacheName).then((cache) => {
                            console.log('[Service Worker] Mise en cache globale: app shell et contenu');
                            return cache.addAll(appShellFiles);
                        })
                    );
                });

                self.addEventListener('fetch', (e) => {
                    e.respondWith(
                        caches.match(e.request).then((r) => {
                            console.log('[Service Worker] Récupération de la ressource: ' + e.request.url);
                            return r || fetch(e.request).then((response) => {
                                return caches.open(cacheName).then((cache) => {
                                    console.log('[Service Worker] Mise en cache de la nouvelle ressource: ' + e.request.url);
                                    cache.put(e.request, response.clone());
                                    return response;
                                });
                            });
                        })
                    );
                });

                //Delete cache 
                self.addEventListener('activate', (e) => {
                    e.waitUntil(
                        caches.keys().then((keyList) => {
                            return Promise.all(keyList.map((key) => {
                                if (cacheName.indexOf(key) === -1) {
                                    return caches.delete(key);
                                }
                            }));
                        })
                    );
                });";


    }

    public function genererKeyApi()
    {
        if ($this->request->isAJAX()) {

            if (service('throttler')->check('genererKeyApi' . $this->request->getIPAddress(), 1, MINUTE) === false) {
                return $this->getResponse(['error' => lang('Auth.tooManyRequests', [service('throttler')->getTokentime()])], 429);
            }
            return $this->getResponse([], 200, ['key_api' => $this->uuid->uuid4()->toString()], 'API key generation');
        }
    }

    /**
     * Update item details.
     *
     * @param string $itemId
     *
     * @return Mixed
     */
    public function updateUser()
    {
        if ($this->request->isAJAX()) {

            if($this->request->getGet('asideToogle') == true){
                $mode = (service('settings')->get('App.theme_bo', 'asideToogle') == 1) ? 0 : 1;
                service('settings')->setUser('App.theme_bo', $mode, 'asideToogle'); 
                return $this->getResponse(['success' => lang('Core.no_content')], 204);
            }

        }

        if($this->request->getGet('darkModeEnabled') == true){
            $mode = (service('settings')->get('App.theme_bo', 'modeDark') == 1) ? 0 : 1;
            service('settings')->setUser('App.theme_bo', $mode, 'modeDark'); 
        }

        if($this->request->getGet('changeLanguageBO') == true){
            service('settings')->setUser('App.language_bo', $this->request->getGet('changeLanguageBO'), 'change'); 
            //preference('App.language_bo-change', $this->request->getGet('changeLanguageBO'));
        }
        
        return redirect()->back();

    }
}
