<?php

namespace Adnduweb\Ci4Core\Controllers\API;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use Psr\Log\LoggerInterface;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;
use Firebase\JWT\JWT;

abstract class BaseApiController extends \CodeIgniter\Controller
{

    /**
     * @var helpers
     */
    protected $helpers = ['detect', 'url', 'form', 'lang'];

    /**
     * Refactored class-wide data array variable
     * 
     * @var array
     */
    protected $viewData = [];

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var Pager
     */
    protected $pager;

    public $locale;

    /**
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * @var \CodeIgniter\Services\encrypter
     */
    protected $encrypter;

    /**
     * @var \Config\Services::validation();
     */
    protected $validation;

    /**
     * @array array ;
     */
    protected $rules;

    /**
     * Silent
     */
    public $silent = true;



    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        
    }

    public function getResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
    {
        return $this
        ->response
        ->setStatusCode($code)
        ->setJSON($responseBody);
    }


    public function getRequestInput(IncomingRequest $request){
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

    public function validateRequest($input, array $rules, array $messages =[]){
        $this->validator = Services::Validation()->setRules($rules);
        // If you replace the $rules array with the name of the group
        if (is_string($rules)) {
            $validation = config('Validation');
    
            // If the rule wasn't found in the \Config\Validation, we
            // should throw an exception so the developer can find it.
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }
    
            // If no error message is defined, use the error message in the Config\Validation file
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }
    
            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }

    protected function checkToken(){

        $key = getenv('JWT_SECRET_KEY');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if(!$header) 
        return $this->getResponse(
            ['error' =>'Token Required 1'],
            ResponseInterface::HTTP_BAD_REQUEST
        );
      
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $response = [
                'id' => $decoded->uuid,
                'email' => $decoded->email
            ];
            return true;
           
        } catch (\Throwable $th) {
            return $this->getResponse(
                ['error' =>'Token Required'],
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

    }
  
}
