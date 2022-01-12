<?php
 
namespace Adnduweb\Ci4Admin\Controllers\Api\v1;
 
// use CodeIgniter\RESTful\ResourceController;
// use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Admin\Entities\User;
use Firebase\JWT\JWT;
use Exception;
use ReflectionException;
 
// class Users extends ResourceController
class Users extends \Adnduweb\Ci4Core\Controllers\API\BaseApiController
{
    // /**
    //  * Return an array of resource objects, themselves in array format
    //  *
    //  * @return mixed
    //  */
    // use ResponseTrait;
    public function index()
    {

        $this->checkToken();
        // $key = getenv('TOKEN_SECRET');
        // $header = $this->request->getServer('HTTP_AUTHORIZATION');
        // if(!$header) return $this->failUnauthorized('Token Required');
        // $token = explode(' ', $header)[1];
 
        // try {
        //     $decoded = JWT::decode($token, $key, ['HS256']);
        //     $response = [
        //         'id' => $decoded->uid,
        //         'email' => $decoded->email
        //     ];
        //     return $this->respond($response);
        // } catch (\Throwable $th) {
        //     return $this->fail('Invalid Token');
        // }

        return $this
        ->getResponse(
            model(UserModel::class)->findAll()
        );

    }

    /**
     * Get a single client by ID
     */
    public function me()
    {

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
            return $this->getResponse(
                $response
            );
           
        } catch (\Throwable $th) {
            return $this->getResponse(
                ['error' =>'Token Required'],
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

    }
 
}