<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class AjaxController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{

    use ResponseTrait;

    /**  @var string  */
    protected $table = "ajax";

    /**  @var string  */
    protected $className = "Ajax";

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


    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function sendMailAccountManager()
    {
        if ($this->request->isAJAX()) {

            $response = json_decode($this->request->getBody());        
            
            if (empty($response->dataPost)) {
                return $this->getResponse(['error' => lang('Core.selectAtLeastOne')], 400);
            }
            if(service('mail')->sendAdmin(
                'fabrice@adnduweb.com', 
                lang('Core.'. $response->type), 
                $response, 
                view('Adnduweb\Ci4Admin\themes\metronic\emails\sendMailAccountManager', ['response' => $response])
            ) == true){

                return $this->getResponse(['success' => lang('Core.Votre demande a été envoyée avec succès')], 200);
            }

        }
    }



}
