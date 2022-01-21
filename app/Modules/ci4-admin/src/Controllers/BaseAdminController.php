<?php

namespace Adnduweb\Ci4Admin\Controllers;

use CodeIgniter\Controller;
use \Adnduweb\Ci4Core\Traits\Themeable;
use \Adnduweb\Ci4Admin\Libraries\Theme;
use \Adnduweb\Ci4Admin\Libraries\Init;
use \Adnduweb\Ci4Admin\Libraries\Validate;
use \Adnduweb\Ci4Admin\Libraries\Tools;
use \Adnduweb\Ci4Admin\Libraries\Breadcrumb;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


abstract class BaseAdminController extends Controller
{

    use Themeable;

    /** @var string */
    public $path;

    /** @var string */
    public $path_redirect;

    /** @var string */
    public static $currentIndex;

     /** @var string */
     public $route;

    /** @var string Security token */
    public $token;

    /*  @var IncomingRequest|CLIRequest*/
    protected $request;

    /** @var array|Traversable Bootstrap variable */
    public $page_header_toolbar_btn = [];

    /** @var string  */
    protected $category;

    /** @var string */
    protected $display;

    /** @var string  */
    protected $className;

    /** @var string|array Toolbar title */
    protected $toolbar_title;
  
    /** @var string|object */
    protected $tableModel = null;  

    /** @var string|false Object identifier inside the associated table */
    protected $identifier = false;

    /** @var ObjectModel Instantiation of the class associated with the AdminController */
    protected $object;

    /** @var array */
    protected $viewData = [];

    /** @var array Errors displayed after post processing */
    public $errors = [];

    /**  @var object */
    protected $uuid;

    /** @var integer  */
    protected $id;

    /** @var integer  */
    protected $uri_edit_segment;

    /** @var string|array */
    protected $meta_title = [];

    /** @var Auth */
    protected $auth;

    /** @var Config */
    protected $config;

    /** @var Db */
    protected $db;

    /** @var Pager */
    protected $pager;

    /** @var object ;*/
    public $locale;

    /** @var \CodeIgniter\Session\Session*/
    protected $session;

    /** @var \CodeIgniter\Services\encrypter */
    protected $encrypter;

    /** @var \Config\Services::validation();  */
    protected $validation;

    /** @var array ;*/
    protected $rules;

    /** @var bool */
    public $silent = true;

    /** @var bool */
    public $filterDatabase = true;

    /** @var bool */
    public $allow_update = true;

     /** @var bool */
    public $allow_change_categorie = false;

     /** @var bool */
    public $allow_export = true;

    /** @var array */
    public $type_export = ['excel', 'pdf', 'csv'];

    /** @var bool */
    public $allow_import = true;

    /** @var bool */
    public $allow_fake = false;

     /** @var bool */
    public $redirectBack = true;

      /** @var bool */
    public $multilangue     = false;

    /** @var bool */
    public  $folderList = false;
    
    /** @var null */
    public  $_method    = null;

    /** @var object */
    protected $controller;

    /** @var array */
    public $notices = [];

    /** @var array */
    public $infos = [];

    /** @var array */
    public $cruds = ['list', 'grid', 'index', 'new', 'create', 'edit', 'store', 'delete' ];


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['preferences', 'detect', 'auth', 'admin', 'url', 'form', 'lang', 'string']);


        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // start benchmarking
        service('timer')->start('elapsed_time_base');

        static::$isBackend = true;

        $this->theme = 'metronic';
        $this->breadcrumb = new Breadcrumb();
        //echo Theme::path($this->theme); exit;
        $this->session   = service('session');
        $this->encrypter = service('encrypter');
        $this->uuid      = service('uuid');

        $this->route          = (isset(service('router')->getMatchedRoute()[0]) ? service('router')->getMatchedRoute()[0] : null);
        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);$end = end($handle);
        $this->controller = strtolower(str_replace('Controller', '', $end));
        $this->_method = service('router')->methodName();
        $this->_module = ($this->_method && strpos( $this->route , $this->_method) !== false ? preg_replace('/\/' . $this->_method . '$/', null,  $this->route ) :  $this->route );

        //Check language
        $this->langue = service('LanguageOverride');
        setlocale(LC_TIME, service('request')->getLocale() . '_' .  service('request')->getLocale());

        $this->token = Tools::getAdminToken(service('router')->controllerName() . (isset(user()->id) ?? null ) . (isset(user()->last_login_at) ?? null ) );
        $this->path_redirect = '/' . CI_AREA_ADMIN . '/' . $this->category . '/' . $this->table;
        $this->display = service('router')->methodName();

        
        $this->auth       = service('authentication');
        $this->settings   = service('settings');
        $this->validation = service('validation');

        $this->tableModel = (!is_null($this->tableModel)) ? new $this->tableModel : null;
        $this->uri_edit_segment = dot_array_search('edit', array_flip(service('uri')->getSegments()));
        $this->id = (empty($this->uri_edit_segment)) ? null : (service('uri')->getSegment($this->uri_edit_segment + 2));

        if (!is_null($this->tableModel) && !$this->identifier) {
            $this->identifier = $this->tableModel->primaryKey;
        }

        // Display theme information
        $this->viewData['html']        = detectBrowser(true);
        $this->viewData['theme_admin'] = $this->theme;
        $this->viewData['meta_title']  = $this->controller;
        $this->viewData['controller']  = $this->table;
        $this->viewData['method']  = $this->display;
        $this->viewData['supportedLocales']  = $this->langue->supportedLocales();

        // Set current index
        $current_index = current_url() . '?token=' . $this->token;
        self::$currentIndex = $current_index;
        $this->back = $this->path_redirect . '?token=' . $this->token;

        Init::run();
        $this->checkPermissions();
        //$this->activeWebpack(); //Active Webpack in dev
        $this->invokeJs();//On écrire le fichier ajax de traduction
        $this->initParamJs(); // Display param js
        $this->initToolbarFlags();
        $this->initBreadcrumbs();

        //var_dump($this->object); exit;
        $fullname = (!is_null($this->object)) ? ' : ' . $this->object->getFullName() : '';  
        $this->setTitle('meta_title', lang('Core.' . service('router')->methodName()) . $fullname);
        service('negotiator')->encoding(['gzip']); 
        service('timer')->stop('elapsed_time_base');

        //print_r($this->viewData); exit;

        $this->controller   = $this;

        return $this;
    }

    // try to cache a setting and pass it back
    protected function cache($key, $content)
    {
        if ($content === null) {
            return cache()->delete($key);
        }

        if ($duration = env('cache.cacheDuration')) {
            cache()->save($key, $content, $duration);
        }
        return $content;
    }

     /**
     * Set breadcrumbs array for the controller page.
     *
     * @param int|null $tab_id
     * @param array|null $tabs
     */
    public function initBreadcrumbs($tab_id = null, $tabs = null)
    {

       /*
        Array
        (
            [0] => admin8C5DfeRq6
            [1] => settings-advanced
            [2] => users
            [3] => edit
            [4] => c59d41af-8e8d-457c-bf9b-09ae79f9a0ca
        )
        */

        if(!empty($this->id)){

            $segments = service('uri')->getSegments();
            $this->breadcrumb->add(lang('Core.home'), '/' . CI_AREA_ADMIN . '/dashboard', null);
            
            if (Validate::isLoadedObject($this->object) ) {
                if(is_array($segments)){
                    $i = 0;
                    foreach($segments as $k => $segment){
                        if($segment != CI_AREA_ADMIN){

                            if($this->category == $segment){
                                $this->breadcrumb->add(cleanTitleDebug($segment), route_to($this->table), null);
                            }

                            if($this->table == $segment){
                                $this->breadcrumb->add(cleanTitleDebug($segment), route_to($this->table), null);
                            }

                            if($i == array_key_last($segments)){
                                $this->breadcrumb->add($this->object->getFullName(), "#", null);
                            }
                        }
                        $i++;

                    }
                }
                $this->viewData['breadcrumbs'] = $this->breadcrumb->render();
            }else{
                $this->errors[] = lang('Core.An error occurred while view for an object.');
            }

            
        }else{

            $this->viewData['breadcrumbs'] = $this->breadcrumb->buildAuto();
        }

       


    }


    public function initToolbarFlags()
    {

        $this->initToolbar();
        $this->initPageHeaderToolbar();
        $this->getNotices();
        $this->getInfos();

        $data = [
            'maintenance_mode' => service('settings')->get('App.core', 'maintenance'),
            'display' => $this->display,
            'debug_mode' => env('CI_ENVIRONMENT'),
            'lite_display' => ( Config('Theme')->layout['header']['display'] === true && Config('Theme')->layout['footer']['display'] === true) ? false : true,
            'url_post' => self::$currentIndex . '&token=' . $this->token,
            'show_page_header_toolbar' => Config('Theme')->layout['header']['display'],
            'page_header_toolbar_title' => $this->page_header_toolbar_title,
            'titleToolbar' => $this->page_header_toolbar_title,
            'page_header_toolbar_btn' => $this->page_header_toolbar_btn,
            'notices' => $this->notices,
            'infos' => $this->infos,
            'filterDatabase' => $this->filterDatabase,
            'allow_fake' =>  $this->allow_fake,
            'allow_update' => $this->allow_update,
            'allow_export' => $this->allow_export,
            'type_export' => $this->type_export,
            'allow_import' => $this->allow_import,
            'allow_change_categorie' => $this->allow_change_categorie,
            'backcategory' => $this->category . '/' . strtolower( $this->className ),
            'multilangue' =>(isset($this->multilangue)) ? $this->multilangue : false
        ];

        $this->viewData = array_merge($data, $this->viewData);
    }

    public function initPageHeaderToolbar()
    {
        if (Config('Theme')->layout['toolbar']['display'] === true){
            $this->initToolbarTitle();
        }

        if (!is_array($this->toolbar_title)) {
            $this->toolbar_title = [$this->toolbar_title];
        }

        switch (service('router')->methodName()) {
            case 'index':
               
                $this->toolbar_title[] = lang('Core.List: %s', [$this->className]);
                $this->addMetaTitle($this->toolbar_title[count($this->toolbar_title) - 1]);
                if (Config('Theme')->layout['header']['display_create'] === true) {
                    $this->page_header_toolbar_btn['create'] = [
                        'color' => 'primary',
                        'href'  => $this->path_redirect .'/create?token=' . $this->token,
                        'svg'   => service('theme')->getSVG("duotune/arrows/arr087.svg", "svg-icon svg-icon-5 m-0"),
                        'desc'  => lang('Core.add'),
                    ];
                }

                break;
            case 'update':
            case 'edit':

                if (Config('Theme')->layout['header']['display'] === true) {
                     $this->page_header_toolbar_btn['back'] = [
                        'color' => 'dark',
                        'href'  => $this->back,
                        'svg'   => service('theme')->getSVG("icons/duotone/Navigation/Arrow-from-right.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                        'desc'  => lang('Core.Back to list'),
                     ];
                     $this->page_header_toolbar_btn['create'] = [
                        'color' => 'primary',
                        'href'  => $this->path_redirect .'/create?token=' . $this->token,
                        'svg'   => service('theme')->getSVG("duotune/arrows/arr087.svg", "svg-icon svg-icon-5 m-0"),
                        'desc'  => lang('Core.add'),
                    ];
                 }
                
                $obj = $this->loadObject(true);
              
                if (Validate::isLoadedObject($obj) && isset($obj->{$this->identifier_name}) && !empty($obj->{$this->identifier_name})) {
                    array_pop($this->toolbar_title);
                    array_pop($this->meta_title);
                    $this->toolbar_title[] = lang('Core.Edit: %s', [$obj->getFullName()]);
                    $this->addMetaTitle($this->toolbar_title[count($this->toolbar_title) - 1]);
                }

                break;
            case 'create':
            case 'new':

                if (Config('Theme')->layout['header']['display'] === true) {
                    $this->page_header_toolbar_btn['back'] = [
                        'color' => 'dark',
                        'href'  => $this->back,
                        'svg'   => service('theme')->getSVG("icons/duotone/Navigation/Arrow-from-right.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                        'desc'  => lang('Core.Back to list'),
                    ];
                    $this->page_header_toolbar_btn['create'] = [
                        'color' => 'primary',
                        'href'  => $this->path_redirect .'/create?token=' . $this->token,
                        'svg'   => service('theme')->getSVG("icons/duotone/Communication/Add-user.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                        'desc'  => lang('Core.add'),
                    ];
                }

                break;
                default:
                     if(!is_null($this->tableModel)){
                        $this->toolbar_btn['new'] = [
                            'color' => 'dark',
                            'svg'   => service('theme')->getSVG("icons/duotone/Communication/Contact1.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
                            'href' => 'javascript:;',
                            'desc' => lang('Core.Help'),
                        ];
                    }
        }

        if (is_array($this->page_header_toolbar_btn)
            && $this->page_header_toolbar_btn instanceof Traversable
            || count($this->toolbar_title)) {
            Config('Theme')->layout['toolbar']['display'] = true;
        }

        if (empty($this->page_header_toolbar_title)) {
            $this->page_header_toolbar_title = $this->toolbar_title[count($this->toolbar_title) - 1];
        }

    }

    /**
     * Set default toolbar_title to admin breadcrumb.
     */
    public function initToolbarTitle()
    {
        //$this->toolbar_title = is_array($this->breadcrumbs) ? array_unique($this->breadcrumbs) : [$this->breadcrumbs];

        switch (service('router')->methodName()) {
            case 'edit':
                $this->toolbar_title[] = lang('Core.Edit');
                $this->addMetaTitle(lang('Core.Edit'));

                break;

            case 'new':
                $this->toolbar_title[] = lang('Core.Add new');
                $this->addMetaTitle(lang('Core.Add new'));

                break;

            case 'index':
                $this->toolbar_title[] = lang('Core.' . $this->className . '_list');
                $this->addMetaTitle(lang('Core.list'));

                break;
        }

        // if ($filter = $this->addFiltersToBreadcrumbs()) {
        //     $this->toolbar_title[] = $filter;
        // }

       
    }

    /**
     * Add an entry to the meta title.
     *
     * @param string $entry new entry
     */
    public function addMetaTitle($entry)
    {
        // Only add entry if the meta title was not forced.
        if (is_array($this->meta_title)) {
            $this->meta_title[] = $entry;
        }
    }

    /**
     * assign default action in toolbar_btn smarty var, if they are not set.
     * uses override to specifically add, modify or remove items.
     */
    public function initToolbar()
    {
        switch (service('router')->methodName()) {
            case 'new':
                $this->viewData['action'] = 'create';
                break;
            case 'edit':
                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = [
                    'href' => '#',
                    'color' => 'dark',
                    'desc' => lang('Core.Save'),
                ];
                $back = service('request')->getGet('back');
                if (empty($back)) {
                    $back = self::$currentIndex . '&token=' . $this->token;
                }
                if (!Validate::isCleanHtml($back)) {
                    die(Tools::displayError());
                }
                if (Config('Theme')->layout['header']['display'] === true) {
                    $this->toolbar_btn['cancel'] = [
                        'href' => $back,
                        'desc' => lang('Core.Cancel'),
                    ];
                }
                $this->viewData['action'] = 'edit';

                break;
            case 'index':
                // Default cancel button - like old back link
                $back = service('request')->getGet('back');
                if (empty($back)) {
                    $back = self::$currentIndex . '&token=' . $this->token;
                }
                if (!Validate::isCleanHtml($back)) {
                    die(Tools::displayError());
                }
                if (Config('Theme')->layout['toolbar']['display'] === false){
                    $this->toolbar_btn['back'] = [
                        'href' => $back,
                        'desc' => lang('Core.Back to list'),
                    ];
                }

                break;
            case 'options':
                $this->toolbar_btn['save'] = [
                    'href' => '#',
                    'desc' => lang('Core.Save'),
                ];

                break;
            default:
               
        }

    }

    /**
     * Load class object using identifier in $_GET (if possible)
     * otherwise return an empty object, or die.
     *
     * @param bool $opt Return an empty object if load fail
     *
     * @return ObjectModel|false
     */
    protected function loadObject($opt = false)
    {

        if (!isset($this->className) || empty($this->className)) {
            return true;
        }

        if (!empty($this->id)) {

            
            //print_r(service('request')->getGet()); exit;
            if ($this->uuid->isValid($this->id)) {
                $this->id = $this->uuid->fromString($this->id)->getBytes();
            } else {
                $this->id = (int) $this->id;
            }

            // Check if uuid exist
            if (isset($this->tableModel->uuidFields)) {

                // Initialize form
                if(isset($this->tableModel->lang) && $this->tableModel->lang == true){
                    $this->object = $this->tableModel
                    ->join($this->tableModel->table . '_langs', $this->tableModel->table .'.'. $this->tableModel->primaryKey . ' =  ' . $this->tableModel->table . '_langs.' . singular($this->tableModel->table) . '_' .$this->tableModel->primaryKey)
                    ->where([$this->tableModel->uuidFields[0] => $this->id])
                    ->where('lang', service('request')->getLocale())
                    ->first();
                   
                }else{
                    $this->object = $this->tableModel->where([$this->tableModel->uuidFields[0] => $this->id])->first();
                }

            } else {

                // Initialize form
                if(isset($this->tableModel->lang) && $this->tableModel->lang == true){
                    $this->object = $this->tableModel
                    ->join($this->tableModel->table . '_langs', $this->tableModel->table .'.'. $this->tableModel->primaryKey . ' =  ' . $this->tableModel->table . '_langs.' . singular($this->tableModel->table) . '_' .$this->tableModel->primaryKey)
                    ->where([$this->tableModel->primaryKey => $this->id])
                    ->where('lang', service('request')->getLocale())
                    ->first();
                }else{
                    $this->object = $this->tableModel->where([$this->tableModel->primaryKey => $this->id])->first();
                }
               
            }

            //print_r($this->object); exit;

            if (Validate::isLoadedObject($this->object)) {
                return $this->object;
            }

            if ($this->silent == true) {
                return false;
            }else{
                $this->errors[] = lang('Core.The object cannot be loaded (or found)');
            }
                
            
        }
        else {
            $this->errors[] = lang('Core.The object cannot be loaded (the identifier is missing or invalid)');
            return false;
        }

    }

    protected function initParamJs()
    {

        $this->viewData['paramJs'] =  [
            'base_url'       => site_url(),
            'current_url'    => current_url(),
            'uri'            => $this->request->uri->getPath(),
            'basePath'       => '\/',
            'baseController' => base_url('/' . env('app.areaAdmin') . '/' . $this->category . '/' . strtolower($this->table)),
            'segementAdmin'  => env('app.areaAdmin'),
            'startUrl'       => '\/' . env('app.areaAdmin'),
            'lang_iso'       => service('settings')->get('App.language_bo', 'isoCurrent'),
            'crsftoken'      => csrf_token(),
           // 'csrfName'       => csrf_token(),
            'csrfHash'       => csrf_hash(),
            'env'            => ENVIRONMENT,
            'SP_VERSION'     => config('BaseModule')->version
        ];

        if (logged_in() == true) {

            foreach ( user()->auth_groups_users as $auth_groups_users) {
                $id_group[] = $auth_groups_users->group_id;
            }

            $this->viewData['paramJs']['user_uuid']           = user()->uuid;
            $this->viewData['paramJs']['id_group']            = json_encode($id_group);
            $this->viewData['paramJs']['activer_multilangue'] = service('settings')->get('App.language_bo', 'multilangue');
            //$this->viewData['paramJs']['supportedLocales']    = implode('|', $this->langue->supportedLocales());
            //$this->viewData['paramJs']['crsftoken']           = csrf_token();
           // $this->viewData['paramJs']['tokenHashPage']       = md5(user()->uuid . strtolower($this->className));
            $this->viewData['paramJs']['tokenHashPage']       = $this->token;
        }
        return $this->viewData['paramJs'];
    }

    /**
     * 
     * Mettre à jour le fichier JS de langue
     */
    public function invokeJs()
    {
        helper('filesystem');
        $files = \Config\Services::locator()->search('Language/' . service('request')->getLocale() . '/Js.php');

        if (!empty($files)) {
            $file  = include($files[0]);
            $htmlJs  = 'var _LANG_ = {';
            $htmlJs .= "\n";
            foreach ($file as $k => $v) {
                $htmlJs .= '"' . $k . '" : ';
                $htmlJs .= '"' . $v . '"';
                $htmlJs .= ', ' . "\n";
            }
            $htmlJs .= "\n";
            $htmlJs .= '}';
            try {
                $write = write_file('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/language/lang_' . service('request')->getLocale() . '.js', $htmlJs);
            } catch (\Exception $e) {

                throw new \RuntimeException('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/language/lang_' . service('request')->getLocale() . '.js');
                exit;
            }
        } else {
            $write = write_file('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/language/lang_' . service('request')->getLocale() . '.js', '');
        }

        //exit;
    }


    /**
     * 
     * --------------------------------------------------------------------------
     * CRUD
     * --------------------------------------------------------------------------
     */


    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function index(): string
    {

       

        // $this->viewData['addcategory'] = $this->category . '/' . strtolower($this->className) .  '/create';

        // if (isset($this->add) && $this->add == true)
        //     $this->viewData['add'] = lang('Core.add_' . strtolower($this->className));

         return true;
    }



   /**
     * Function datatable.
     *
     * @return CodeIgniter\Http\Response
     */
    public function ajaxDatatable(): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search[value]');
            $order = $this->tableModel::ORDERABLE[$this->request->getVar('order[0][column]')];
            $dir = $this->request->getVar('order[0][dir]');

           return $this
            ->response
            ->setStatusCode(200)
            ->setJSON([
                'draw'            => $this->request->getVar('draw'),
                'recordsTotal'    => $this->tableModel->getResource()->countAllResults(),
                'recordsFiltered' => $this->tableModel->getResource($search)->countAllResults(),
                'data'            => $this->convertBinToUuid($this->tableModel->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject()),
                'token'           => csrf_hash()
            ]);

        }

        return $this->getResponse(['success' => lang('Core.no_content')], 204);
    }

    /**
     * Shows details for one item.
     *
     * @param string $itemId
     *
     * @return string
     */
    public function edit(string $id): string
    {

        $this->errors = array_unique($this->errors);

        //print_r($this->errors); exit;
        if (!empty($this->errors)) {
            // if we have errors, we stay on the form instead of going back to the list
            $html = '<ul>';
            foreach($this->errors as $error){ 
                $html .= '<li>' .  $error . '</li>';
            } 
            $html .= '</ul>';
            //http://ci43.lan/admin8C5DfeRq6/settings-advanced/users/edit/2424cf20-fdcertee-4540-b9ab-4614759aece8
            Theme::set_message('error', $html, lang('Core.warning_error'));
            header('Location: ' . route_to('dashboard'));
            exit;
        }

        return  true;

    }

    /**
     * Displays the form for a new item.
     *
     * @return string
     */
    public function new()
    {
        if(!has_permission($this->table . '-edit')){

            if ( service('request')->isAJAX()) {
                return $this->getResponse(['success' => lang('Core.no_content')], 204);
            }

            Theme::set_message('error', 'You do not have permission to do that', lang('Core.warning_error'));
            header('Location: ' . route_to('dashboard'));
            exit;
        }
       
    }

 

   /**
     * Update item details.
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function update(string $id)
    {

        if ($this->uuid->isValid($id)) {
            $this->id = $this->uuid->fromString($id)->getBytes();
        } else {
            $this->id = (int) $id;
        }
    }

    /**
     * Update item details.
     */
    public function updateAjax()
    {

        if ( !service('request')->isAJAX()) {
            return $this->getResponse(['success' => lang('Core.no_content')], 204);
        }

        if ( service('request')->getMethod() == 'post') {

            $response = json_decode(service('request')->getBody());

            $this->id = (isset($response->id)) ? $response->id : $response->uuid; 
            $this->loadObject(true);

        }
    }

    /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function delete(): ResponseInterface
    {

    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function remove($id)
    // {

    // }

    // protected function getToolbar()
    // {

    //     $this->viewData['title'] = lang( 'Core.' . strtolower( $this->className ) );
    //     $this->viewData['add_item'] = $this->category . '/' . strtolower( $this->className ) .  '/add';
    //     $this->viewData['redirectBack'] = $this->redirectBack;
    //     $this->viewData['filterDatabase'] = $this->filterDatabase;
    //     $this->viewData['allow_fake'] = $this->allow_fake;
    //     $this->viewData['allow_update'] = $this->allow_update;
    //     $this->viewData['allow_export'] = $this->allow_export;
    //     $this->viewData['allow_change_categorie'] = $this->allow_change_categorie;
    //     $this->viewData['backcategory'] = $this->category . '/' . strtolower( $this->className );
    //     $this->viewData['multilangue'] = (isset($this->multilangue)) ? $this->multilangue : false;
    // }



    // protected function sanitizePhone(object $object)
    // {

    //     if (isset($object->full_phone) && !empty($object->full_phone)) {
    //         $phoneInternationalPhone = $this->phoneInternational($object->full_phone);
    //         if ($phoneInternationalPhone['status'] == 200) {

    //             $object->phone = $phoneInternationalPhone['message'];
    //         } else {
    //             return ['error' => ['code' => 400, 'message' => lang('Core.' . $phoneInternationalPhone['message'] . ': phone')], 'success' => false, csrf_token() => csrf_hash()];
    //         }
    //     }

    //     if (isset($object->full_phone_mobile) && !empty($object->full_phone_mobile)) {
    //         $phoneInternationalMobile = $this->phoneInternational($object->full_phone_mobile);
    //         if ($phoneInternationalMobile['status'] == 200) {

    //             $object->phone_mobile = $phoneInternationalMobile['message'];
    //         } else {
    //             return ['error' => ['code' => 400, 'message' => lang('Core.' . $phoneInternationalMobile['message'] . ': phone_mobile')], 'success' => false, csrf_token() => csrf_hash()];
    //         }
    //     }

    //     //return $object;

    // }

    /**
	 * Handles failures.
	 * https://www.twilio.com/blog/create-secured-restful-api-codeigniter-php REST API
	 * @param int $code
	 * @param string $message
	 * @param boolean|null $isAjax
	 */
	protected function failure(int $code, string $message, bool $isAjax = null)
	{
		log_message('debug', $message);

		if ($isAjax ?? service('request')->isAJAX())
		{

            $response = [
                'status'   => $code,
                'error'    => true,
                'messages' => [
                    'error' => $message
                ],
                csrf_token() => csrf_hash()
            ];

			return $this->response->setStatusCode($code)->setJSON($response);
		}

		return redirect()->back()->with('error', $message);
    }

     /**
	 * Handles failures.
	 * @param array $responseBody
	 * @param int $code
	 */
    public function getResponse(array $responseBody,int $code = ResponseInterface::HTTP_OK, array $other_data = [], $reason_phrase = false )
    {

       $response = [
            'status'   => $code,
            'error'    => null,
            'messages' => $responseBody,
            csrf_token() => csrf_hash()
        ];

        if(is_array($other_data) && !empty($other_data))
        foreach ($other_data as $k => $v){
            $response[$k] = $v; 
        }

        if($reason_phrase != false)
            return $this->response->setStatusCode($code, $reason_phrase)->setJSON($response);
        else
            return $this->response->setStatusCode($code)->setJSON($response);
    }

      /**
	 * Handles failures.
	 * @param object $request
	 * @param int $code
	 */
    public function getRequestInput(IncomingRequest $request){
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

    

    public function setTitle( string $key, string $title ){

        $this->viewData[$key] = $title;

    }

    protected function convertBinToUuid(array $data){

        if(isset($this->tableModel->uuidFields) && !empty($this->tableModel->uuidFields) ){

            // Must use the set() method to ensure to set the correct escape flag
            $i = 0;
            foreach ($data as &$val)
            {
                // Convert UUID fields if needed
                if ($val->uuid && in_array('uuid', $this->tableModel->uuidFields) && $this->tableModel->uuidUseBytes === true){
                    $val->uuid = $this->uuid->fromBytes($val->uuid)->toString();
                }
               
                $i++;
            }
        }

        return $data;

    }

    public function getListUsersLight(){

        return model(UserModel::class)->getListUsersLight();

    }

    public function getNotices(){
        if (!empty(service('session')->entantque) ) { 
            $this->notices['en-tant-que'] = service('Tools')->notice(lang('Core.Attention Vous êtes connecté en tant que : ' . user()->lastname . '<br/> Pour revenir à votre compte vous pouvez cliquer <a href="'.route_to('user-return-compte', service('session')->entantque).'">ici</a> ' . user()->firstname), 'info');
        }
        return $this->notices;
    
    }

    public function getInfos(){
       
        return $this->infos;
    
    }

    public function __not_implemented(){
        throw new \RuntimeException('Not yet implemented');

    }

    public function checkPermissions(){

        if(!logged_in())
            return false;

        // On vérifie que l'on peut enregistrer un item 
        if( $this->display == 'create' && has_permission($this->controller . '.new'))
            return true;

        if(in_array($this->display, $this->cruds)) {

            if(!has_permission($this->controller . '.'. $this->display)){

                if ( service('request')->isAJAX()) {
                    return $this->getResponse(['success' => lang('Core.You do not have permission to do that')], 401);
                }
    
                Theme::set_message('error', lang('Core.You do not have permission to do that'), lang('Core.warning_error'));
                header('Location: ' . route_to('dashboard'), 401);
                exit;
            }
        }

       

    }
}
