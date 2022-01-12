<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Libraries\Theme;
use CodeIgniter\API\ResponseTrait;

class CacheController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;

    /**  @var string  */
    protected $table = null;

    /**  @var string  */
    protected $className = 'Cache';

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = '';

    /**  @var object  */
    public $tableModel = null;


    /**
     * Displays a list of available.
     *
     * @return RedirectResponse
     */
    public function clearCache(): RedirectResponse
    {

        $type = $this->request->getGet('type');

        if (empty($type))
                return false;

            switch ($type) {
                case 'script':

                    foreach (glob(ROOTPATH . "public/backend/themes/".service('settings')->get('App.theme_bo', 'name')."/cache/asj_*") as $filename) {
                        @unlink($filename);
                    }

                    foreach (glob(ROOTPATH . "public/backend/themes/".service('settings')->get('App.theme_fo', 'name')."/cache/asj_*") as $filename) {
                        @unlink($filename);
                    }
                    
                    foreach (glob(WRITEPATH . "cache/asj_*") as $filename) {
                        @unlink($filename);
                    }

                    Theme::set_message('success', lang('Core.cache_vide'), lang('Core.cool_success'));
                    return redirect()->back();

                    break;
                case 'ci4':

                    command('cache:clear');

                    Theme::set_message('success', lang('Core.cache_vide'), lang('Core.cool_success'));
                    return redirect()->back();

                    break;
            }
    }

}
