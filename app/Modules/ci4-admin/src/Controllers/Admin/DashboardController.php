<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Models\DashboardModel;
use Carbon\Carbon;

class DashboardController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    /**  @var string  */
    protected $table = "dashboard";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin\Controllers\Dashboard";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = '';

    /**  @var object  */
    public $tableModel = DashboardModel::class;


    public function index(): string
    {
        Config('Theme')->layout['toolbar']['display'] = false;
        $this->viewData['meta_title'] = lang('Core.meta_title') ;
        $this->viewData['meta_description'] = lang('Core.meta_description') ;

        $this->setTitle('title', lang('Core.dashboard'));

        return $this->render($this->viewPrefix . $this->theme . '/\pages\dashboard', $this->viewData);
    }

    public function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/' . PHP_VERSION],
            ['name' => 'Codeigniter version',   'value' => \CodeIgniter\CodeIgniter::CI_VERSION],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => $this->request->getServer('SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => env('cache.Handler')],
            ['name' => 'Session driver',    'value' => env('app.sessionDriver')],

            ['name' => 'Timezone',          'value' => env('app.appTimezone')],
            ['name' => 'Locale',            'value' => env('app.defaultLocale')],
            ['name' => 'Env',               'value' => env('CI_ENVIRONMENT')],
            ['name' => 'URL',               'value' => env('app.baseURL')],
        ];
        return $envs;

        //return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/environment', $envs);
    }

    public static function extensions()
    {
        $extensions = [
            'helpers' => [
                'name' => 'laravel-admin-ext/helpers',
                'link' => 'https://github.com/laravel-admin-extensions/helpers',
                'icon' => 'gears',
            ],
            'log-viewer' => [
                'name' => 'laravel-admin-ext/log-viewer',
                'link' => 'https://github.com/laravel-admin-extensions/log-viewer',
                'icon' => 'database',
            ],
            'backup' => [
                'name' => 'laravel-admin-ext/backup',
                'link' => 'https://github.com/laravel-admin-extensions/backup',
                'icon' => 'copy',
            ],
            'config' => [
                'name' => 'laravel-admin-ext/config',
                'link' => 'https://github.com/laravel-admin-extensions/config',
                'icon' => 'toggle-on',
            ],
            'api-tester' => [
                'name' => 'laravel-admin-ext/api-tester',
                'link' => 'https://github.com/laravel-admin-extensions/api-tester',
                'icon' => 'sliders',
            ],
            'media-manager' => [
                'name' => 'laravel-admin-ext/media-manager',
                'link' => 'https://github.com/laravel-admin-extensions/media-manager',
                'icon' => 'file',
            ],
            'scheduling' => [
                'name' => 'laravel-admin-ext/scheduling',
                'link' => 'https://github.com/laravel-admin-extensions/scheduling',
                'icon' => 'clock-o',
            ],
            'reporter' => [
                'name' => 'laravel-admin-ext/reporter',
                'link' => 'https://github.com/laravel-admin-extensions/reporter',
                'icon' => 'bug',
            ],
            'redis-manager' => [
                'name' => 'laravel-admin-ext/redis-manager',
                'link' => 'https://github.com/laravel-admin-extensions/redis-manager',
                'icon' => 'flask',
            ],
        ];

        foreach ($extensions as &$extension) {
            $name = explode('/', $extension['name']);
            $extension['installed'] = array_key_exists(end($name), Admin::$extensions);
        }

        return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/extensions', $extensions);
    }

    public static function dependencies()
    {
        $json = file_get_contents(ROOTPATH . '/composer.json');

        $dependencies = json_decode($json, true)['require'];
        return $dependencies;

        // return view('Admin/' . getenv('app.themeAdmin') . '/controllers/dashboard/__partials/dependencies', $dependencies);
    }

    public function widgetTwo(){
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $data = collect(json_decode(file_get_contents(WRITEPATH . '/uploads/samples/sales.json')));

        $d = $data->groupBy(function ($data) {
            return Carbon::parse($data->datetime)->format('Y-m');
        })->map(function ($data) {
            return [
                'profit'  => number_format($data->sum('profit') / 11, 2),
                'revenue' => number_format($data->sum('revenue') / 13, 2),
            ];
        })->sortKeys()->mapWithKeys(function ($data, $key) use ($months) {
            return [$months[Carbon::parse($key)->format('n')] => $data];
        });

        return $this->response->setStatusCode(200)->setJSON($d);

    }

    // public function initPageHeaderToolbar()
    // {
    //     if (Config('Theme')->layout['toolbar']['display'] === true){
    //         $this->initToolbarTitle();
    //     }

    //     if (!is_array($this->toolbar_title)) {
    //         $this->toolbar_title = [$this->toolbar_title];
    //     }

    //     switch (service('router')->methodName()) {
    //         case 'index':
               
    //             $this->toolbar_title[] = lang('Core.List: %s', [$this->className]);
    //             $this->addMetaTitle($this->toolbar_title[count($this->toolbar_title) - 1]);
    //             if (Config('Theme')->layout['header']['display_create'] === true) {
    //                 $this->page_header_toolbar_btn['create'] = [
    //                     'color' => 'primary',
    //                     'href'  => $this->path_redirect .'/create?token=' . $this->token,
    //                     'svg'   => service('theme')->getSVG("icons/duotone/Communication/Add-user.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                     'desc'  => lang('Core.add'),
    //                 ];
    //             }

    //             break;
    //         case 'update':
    //         case 'edit':

    //             if (Config('Theme')->layout['header']['display'] === true) {
    //                  $this->page_header_toolbar_btn['back'] = [
    //                     'color' => 'dark',
    //                     'href'  => $this->back,
    //                     'svg'   => service('theme')->getSVG("icons/duotone/Navigation/Arrow-from-right.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                     'desc'  => lang('Core.Back to list'),
    //                  ];
    //                  $this->page_header_toolbar_btn['create'] = [
    //                     'color' => 'primary',
    //                     'href'  => $this->path_redirect .'/create?token=' . $this->token,
    //                     'svg'   => service('theme')->getSVG("icons/duotone/Communication/Add-user.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                     'desc'  => lang('Core.add'),
    //                 ];
    //              }
                
    //             $obj = $this->loadObject(true);
              
    //             if (Validate::isLoadedObject($obj) && isset($obj->{$this->identifier_name}) && !empty($obj->{$this->identifier_name})) {
    //                 array_pop($this->toolbar_title);
    //                 array_pop($this->meta_title);
    //                 $this->toolbar_title[] = lang('Core.Edit: %s', [$obj->getFullName()]);
    //                 $this->addMetaTitle($this->toolbar_title[count($this->toolbar_title) - 1]);
    //             }

    //             break;
    //         case 'create':
    //         case 'new':

    //             if (Config('Theme')->layout['header']['display'] === true) {
    //                 $this->page_header_toolbar_btn['back'] = [
    //                     'color' => 'dark',
    //                     'href'  => $this->back,
    //                     'svg'   => service('theme')->getSVG("icons/duotone/Navigation/Arrow-from-right.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                     'desc'  => lang('Core.Back to list'),
    //                 ];
    //                 $this->page_header_toolbar_btn['create'] = [
    //                     'color' => 'primary',
    //                     'href'  => $this->path_redirect .'/create?token=' . $this->token,
    //                     'svg'   => service('theme')->getSVG("icons/duotone/Communication/Add-user.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                     'desc'  => lang('Core.add'),
    //                 ];
    //             }

    //             break;
    //             default:
    //                  if(!is_null($this->tableModel)){
    //                     $this->toolbar_btn['new'] = [
    //                         'color' => 'dark',
    //                         'svg'   => service('theme')->getSVG("icons/duotone/Communication/Contact1.svg", "svg-icon-5 svg-icon-gray-500 me-1"),
    //                         'href' => 'javascript:;',
    //                         'desc' => lang('Core.Help'),
    //                     ];
    //                 }
    //     }

    //     if (is_array($this->page_header_toolbar_btn)
    //         && $this->page_header_toolbar_btn instanceof Traversable
    //         || count($this->toolbar_title)) {
    //         Config('Theme')->layout['toolbar']['display'] = true;
    //     }

    //     if (empty($this->page_header_toolbar_title)) {
    //         $this->page_header_toolbar_title = $this->toolbar_title[count($this->toolbar_title) - 1];
    //     }

    //     // $this->context->smarty->assign('help_link', 'https://help.prestashop.com/' . service('request')->getLocale() . '/doc/'
    //     //     . service('request')->getGet('controller') . '?version=' . CI_VERSION . '&country=' . service('request')->getLocale());
    // }

}
