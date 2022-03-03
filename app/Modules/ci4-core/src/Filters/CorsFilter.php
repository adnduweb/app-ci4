<?php

namespace Adnduweb\Ci4Core\Filters;

use CodeIgniter\Config\Factories;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Core\Core\ServiceCors;

class CorsFilter implements FilterInterface
{
    /**
     * @var \Adnduweb\Ci4Core\ServiceCors $cors
     */
    protected $cors;

    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {
//print_r($request->getUri()); exit;
        if($request->getUri()->getSegment(1) == 'api'){
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == "OPTIONS"){
                die();
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
      
    }
}
