<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\API\ResponseTrait;

class ChangelogsController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;

    /**  @var string  */
    protected $table = "changelogs";

    /**  @var string  */
    protected $className = "Changelog";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = '';

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
        
        helper('text');

        //$this->viewData['now'] = new Time('now');

         parent::index();

         return $this->render($this->viewPrefix . $this->theme . '/\pages\changelogs\index', $this->viewData);
         
    }

    
}
