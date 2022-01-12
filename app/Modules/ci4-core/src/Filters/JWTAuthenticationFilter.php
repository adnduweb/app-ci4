<?php

namespace Adnduweb\Ci4Core\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Config\Services;


class JWTAuthenticationFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {

        $key = getenv('JWT_SECRET_KEY');
        $header = $request->getServer('HTTP_AUTHORIZATION');
        if(!$header) return Services::response()
                            ->setJSON(['msg' => 'Token Required'])
                            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        $token = explode(' ', $header)[1];
 
        try {
            JWT::decode($token, $key, ['HS256']);
        } catch (\Throwable $th) {
            return Services::response()
                            ->setJSON(['msg' => 'Invalid Token'])
                            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request,
                          ResponseInterface $response,
                          $arguments = null)
    {
    }
}