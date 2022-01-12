<?php

namespace Adnduweb\Ci4Admin\Controllers\Api\v1;

// use CodeIgniter\RESTful\ResourceController;
// use CodeIgniter\API\ResponseTrait;
// use Adnduweb\Ci4Admin\Entities\User;
// use Adnduweb\Ci4Admin\Models\UserModel;
// use Adnduweb\Ci4Admin\Libraries\Password;
// use Firebase\JWT\JWT;


// class Auth extends ResourceController
// {

//     protected $format    = 'json';

//     /**
//      * Return an array of resource objects, themselves in array format
//      *
//      * @return mixed
//      */
//     use ResponseTrait;
//     public function index()
//     {
//         helper(['form']);
//         $rules = [
//             'email' => 'required|valid_email',
//             'password' => 'required|min_length[6]'
//         ];
//         if(!$this->validate($rules)) 
//             return $this->fail($this->validator->getErrors());
            
//         $model = new UserModel();
//         $user = $model->where("email", $this->request->getVar('email'))->first();

//         //print_r($user); exit;
//         if(empty($user))
//         return $this->failNotFound('Email Not Found');
 
//         // Now, try matching the passwords.
//         if (! Password::verify($this->request->getVar('password'), $user->password_hash)){
//             return $this->fail('Wrong Password');
//         }
 
//         $key = getenv('JWT_SECRET_KEY');
//         $payload = array(
//             "iat" => 1356999524,
//             "nbf" => 1357000000,
//             "uid" => $user->uuid,
//             "email" => $user->email
//         );
 
//         $token = JWT::encode($payload, $key);

//         return $this->respond($token);
 
//     }
// }

use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Adnduweb\Ci4Admin\Models\UserModel;
use Exception;
use ReflectionException;

class Auth extends \Adnduweb\Ci4Core\Controllers\API\BaseApiController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function register()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

 $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $userModel = new UserModel();
       $userModel->save($input);
     

       

return $this
            ->getJWTForUser(
                $input['email'],
                ResponseInterface::HTTP_CREATED
            );

    }

    /**
     * Authenticate Existing User
     * @return Response
     */
    public function index()
    {
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email',
            'password' => 'required|min_length[6]|max_length[255]|validateUser[email, password]'
        ];

        $errors = [
            'password' => [
                'validateUser' => 'Invalid login credentials provided'
            ]
        ];

        $input = $this->getRequestInput($this->request);


        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
       return $this->getJWTForUser($input['email']);

       
    }

    private function getJWTForUser(
        string $emailAddress,
        int $responseCode = ResponseInterface::HTTP_OK
    )
    {
        try {
            helper('auth');
            helper('jwt');
            $model = new UserModel();
            $user = $model->findUserByEmailAddress($emailAddress);
            unset($user->password);
            $user->role = (isSuperUser( $user->id )) ? 'ROLE_ADMIN' : 'ROLE_MODERATOR'; 
            $user->authToken = getSignedJWTForUser($user);

           

            $iat = time(); // current timestamp value
            $nbf = $iat + 10;
            $exp = $iat + 3600;

            return $this
                ->getResponse(
                    [
                        'message' => 'User authenticated successfully',
                        'user' => $user,
                        'authToken' => $user->authToken,
                        "iat" => $iat, // issued at
                        "nbf" => $nbf, //not before in seconds
                        "exp" => $exp, // expire time in seconds
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}
