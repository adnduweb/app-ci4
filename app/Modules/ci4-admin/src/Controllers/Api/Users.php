<?php

namespace Adnduweb\Ci4Admin\Controllers\Api;

use \Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;

class Users extends ResourceController
{
    protected $modelName = 'Adnduweb\Ci4Admin\Models\UserModel';
    protected $format    = 'json';

    public function __construct()
    {
        $this->encrypter = service('encrypter');
        $this->time = new Time();
        $this->akademi = new UserModel();
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return $this->respond('aa', 200);
    }

     /**
     * Display a listing of the resource.
     *
     */
    public function list()
    {
        $grant_type = $this->request->getHeaderLine('Grant-Type');

        if ($grant_type == 'access_token') {
            $check_token = $this->checkToken();
        } else if ($grant_type == 'refresh_token') {
            // $refresh_token = $this->refreshToken();
            // return $this->respond($refresh_token, 200);
            // die;
        }

        return $this->respond(['list' => true, csrf_token() => csrf_hash()], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        return $this->respond(['store'], 200);
    }
    /**
     * Display the specified resource.
     *
     */
    public function show($users_id = null)
    {
        return $this->respond(['bou'], 200);
    }

    /**
     *
     *
     */
    public function create()
    {
        return $this->respond(['create'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update($users_id = null)
    {
        return $this->respond(['update'], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($users_id = null)
    {
        return $this->respond(['delete'], 200);
    }

    /**
     * 
     * 
     */
    public function checkToken()
    {
        $secret_key = $this->encrypter->key;

        // ambil bearer token
        $post = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $post); // agar kata 'bearer' dalam token hilang
        $token = $arr[1]; // mengambil nilai token saja

        if ($token != null) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256')); // std class object
                if ($decoded) {
                    return true;
                }
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
