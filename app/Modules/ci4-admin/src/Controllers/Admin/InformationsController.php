<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class InformationsController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;

    /**  @var string  */
    protected $table = "informations";

    /**  @var string  */
    protected $className = "Information";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = null;

    /**  @var string  */
    public $identifier_name = 'name';

    /** @var bool */
    public $filterDatabase = false;


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
        service('Theme')::add_js('plugins/custom/datatables/datatables.bundle.js');
        parent::index();
        $this->viewData['envs'] = $this->environment();
        $this->viewData['extenions'] = $this->extensions();
        $this->viewData['dependencies'] = $this->dependencies();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\informations\index', $this->viewData);
    }




    public function environment()
    {
        $cache = \Config\Services::cache();
        helper(['time', 'text']);

        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/' . PHP_VERSION],
            ['name' => 'App version',       'value' => service('settings')->get('App.core', 'latestRelease')],
            ['name' => 'Theme Admin version',       'value' => service('settings')->get('App.theme_bo', 'version')],
            ['name' => 'Codeigniter version',   'value' => \CodeIgniter\CodeIgniter::CI_VERSION],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => $this->request->getServer('SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => [env('cache.handler'),  $cache->getCacheInfo()]],
            ['name' => 'Durée du Cache',    'value' => timeAgo(env('cache.CacheDuration'))],
            ['name' => 'Cache path',        'value' =>  config('Cache')->storePath],
            ['name' => 'Session driver',    'value' => env('app.sessionDriver')],

            ['name' => 'Timezone',          'value' => env('app.appTimezone')],
            ['name' => 'Locale',            'value' => service('request')->getLocale()],
            ['name' => 'Env',               'value' => env('CI_ENVIRONMENT')],
            ['name' => 'URL',               'value' => env('app.baseURL')],


        ];
        return $envs;

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
        }

    }

    public static function dependencies()
    {
        $json = file_get_contents(ROOTPATH . 'composer.json');

        $dependencies = json_decode($json, true)['require'];
        return $dependencies;
    }
}
