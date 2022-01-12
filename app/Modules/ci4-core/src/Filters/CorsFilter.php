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

    // /**
    //  * Constructor.
    //  *
    //  * @param array $options
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $config = Factories::config('Cors');

    //     $this->cors = new ServiceCors([
    //         'allowedHeaders'         => $config->allowedHeaders,
    //         'allowedMethods'         => $config->allowedMethods,
    //         'allowedOrigins'         => $config->allowedOrigins,
    //         'allowedOriginsPatterns' => $config->allowedOriginsPatterns,
    //         'exposedHeaders'         => $config->exposedHeaders,
    //         'maxAge'                 => $config->maxAge,
    //         'supportsCredentials'    => $config->supportsCredentials,
    //     ]);
    // }

    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        // if ($this->cors->isPreflightRequest($request)) {
        //     $response = $this->cors->handlePreflightRequest($request);

        //     $this->cors->varyHeader($response, 'Access-Control-Request-Method');

        //     return $response;
        // }

        header("Access-Control-Allow-Origin: http://localhost:4200");
        //header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
        header("Access-Control-Allow-Headers: origin, x-api-key, x-requested-with, content-type, accept, access-control-request-method, access-control-allow-headers, authorization, observe, enctype, content-length, x-csrf-token");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS"){
            header("HTTP/1.1 200 OK");
            die();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (! $response->hasHeader('Access-Control-Allow-Origin')) {
            return $this->cors->addActualRequestHeaders($response, $request);
        }
    }
}
