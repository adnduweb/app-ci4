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

}
