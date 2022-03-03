<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\Events\Events;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class AuthenticationController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait;


    /**  @var string  */
    protected $table = "users";

    /**  @var string  */
    protected $className = "User";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin\Controllers\AuthenticationController";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var object  */
    public $tableModel = UserModel::class;

   /**  @var string  */
    protected $page = 'login-back-off';

    /**
     *
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    //protected $helpers = ['auth', 'inflector', 'html', 'common', 'form', 'url'];
    protected $helpers = ['form', 'date', 'detect', 'admin', 'url', 'auth'];


    /**
     * @var Auth
     */
    protected $themeAdmin;

    public function __construct()
    {

        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->setting = service('settings');
    }

    //--------------------------------------------------------------------
    // Login/out
    //--------------------------------------------------------------------

    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     */
    public function index() : string
    {
       
        $this->viewData['metatitle'] = lang('Auth.loginTitle');
        $this->viewData['config'] = $this->config;

        return $this->render($this->viewPrefix . $this->theme . '\auth\login', $this->viewData);
    }


    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     */
    public function attemptLogin()
    {
        if ($this->request->isAJAX()) {
            $let = [];
            $rules = [
                'login'    => 'required',
                'password' => 'required',
            ];
            if ($this->config->validFields == ['email']) {
                $rules['login'] .= '|valid_email';
            }

            $this->ensureIsNotRateLimited();


            if (!$this->validate($rules)) {
                return $this->getResponse(['error' => $this->validator->listErrors()], 500);
            }

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');
            $remember = (bool) $this->request->getPost('remember');

            // Determine credential type
            $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


            // Try to log them in...
            if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
                return $this->getResponse(['error' => $this->auth->error() ?? lang('Auth.badAttempt')], 422);
            }

            // Is the user being forced to reset their password?
            if ($this->auth->user()->force_pass_reset === true) {
                return $this->getResponse(['success' =>lang('Auth.loginSuccess')], 200, ['redirect' => route_to('reset-password') .'?token='.$this->auth->user()->reset_hash]);
            }

            $user =  $this->auth->user();
            $users = new UserModel();
            // Success! Save the new password, and cleanup the reset hash.
            $user->password         = $this->request->getPost('password');
            $user->reset_hash       = null;
            $user->reset_at         = date('Y-m-d H:i:s');
            $user->reset_expires    = null;
            $user->force_pass_reset = false;
            $users->save($user);


            //Connexion unique
            if (service('settings')->get('App.core', 'connexionUnique') == '1') {
                // on regarde Si une session est active
                if (count($this->auth->getSessionActive()) > 0) {
                    $this->auth->logout();
                    return $this->getResponse(['error' => lang('Core.attention_deja_connexion_unique') ?? lang('Auth.badAttempt')], 422);
                }
            }

            // ON récupére le groupe principal
            $groupModel = new \Adnduweb\Ci4Admin\Models\GroupModel();
            $getGroupsForUser = $groupModel->getGroupsForUser($this->auth->user()->id);
            if (empty($getGroupsForUser[0]['login_destination']))
                $getGroupsForUser[0]['login_destination'] = 'dashboard';


            $redirectURL = session('redirect_url') ?? '/' . env('app.areaAdmin') . '/' . $getGroupsForUser[0]['login_destination']; 
            unset($_SESSION['redirect_url']);

            $user->last_login_at = date('Y-m-d H:i:s');
            $user->two_factor_confirmed = 0;
            $user->last_login_ip = $this->request->getIPAddress();
    
            $users->save($user);

            $key = getenv('TOKEN_SECRET');

            $iat = time();
            $nbf = $iat + 10;
            $exp = $iat + getenv('app.sessionExpiration'); 
    
            $payload = array(
                "iss" => "The_claim",
                "aud" => "The_Aud",
                "iat" => $iat,
                "nbf" => $nbf,
                "exp" => $exp,
                "uid" => $user->id,
                "email" => $user->email
            );
            $token = JWT::encode($payload, $key, 'HS256');

            $let['app']['accessToken'] = $token;
            $let['app']['id'] = $user->id;
            $let['app']['email'] = $user->email;


            // Double authentification
            if($user->isTwoFactorActive()){

                $let['two_factor'] = $user->isTwoFactorActive();
                $let['redirect'] = route_to('two-factor-auth-2fa');

                return $this->getResponse(['success' => lang('Auth.loginSuccess')], 200, $let);
            }
            

            $let['redirect'] = $redirectURL;

            return $this->getResponse(['success' => lang('Auth.loginSuccess')], 200, $let);
        }
        return redirect()->to(route_to('login-area')); 
    }

    /**
     * Log the user out.
     */
    public function doLogout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(route_to('login-area'));
    }

    //--------------------------------------------------------------------
    // Register
    //--------------------------------------------------------------------

    /**
     * Displays the user registration page.
     */
    public function register()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $this->viewData['metatitle'] = lang('Auth.register');

        return view($this->config->views['register'], ['config' => $this->config]);
    }

    /**
     * Attempt to register a new user.
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $users = new UserModel();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = array_merge($users->getValidationRules(['only' => ['username']]), [
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|strong_password',
            'confirm-password' => 'required|matches[password]',
        ]);

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // Save the user
        $user = new User($this->request->getPost());

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // Success!
        return redirect()->route('login-area')->with('message', lang('Auth.registerSuccess'));
    }

    //--------------------------------------------------------------------
    // Forgot Password
    //--------------------------------------------------------------------

    /**
     * Displays the forgot password form.
     */
    public function forgotPassword()
    {
        if ($this->config->activeResetter === false) {
            return redirect()->route('login-area')->with('error', lang('Auth.forgotDisabled'));
        }

        $this->viewData['metatitle'] = lang('Auth.forgotYourPassword');

        return $this->render($this->viewPrefix . $this->theme . '\auth\forgot-password', $this->viewData);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     */
    public function attemptForgot()
    {
        if ($this->request->isAJAX()) {

            if ($this->config->activeResetter === false) {
                return $this->getResponse(['error' => lang('Core.forgotDisabled')], 422);
            }


            $users = model(UserModel::class);

            $user = $users->where('email', $this->request->getPost('email'))->first();

            if (is_null($user)) {
                return $this->getResponse(['error' => lang('Core.forgotNoUser')], 422);
            }

            // Save the reset hash /
            $user->generateResetHash();
            $users->save($user);

            $resetter = service('resetter');
            $sent = $resetter->send($user);

            //fabrice@adnduweb.com
            if (!$sent) {
                return $this->getResponse(['error' => $resetter->error() ?? lang('Auth.unknownError')], 422);
            }

            return $this->getResponse(['success' => lang('Auth.forgotEmailSent')], 200, ['redirect' => route_to('reset-password')]);
        }
        return redirect()->to(route_to('forgot-password'));
    }

    /**
     * Displays the Reset Password form.
     */
    public function resetPassword() 
    {

        if ($this->config->activeResetter === false) {
            return redirect()->route('login-area')->with('error', lang('Auth.forgotDisabled'));
        }

        session()->set(['wait_valid_two_factor' => true]);
        $this->viewData['token'] = $this->request->getGet('token');

        $this->viewData['metatitle'] = lang('Auth.resetYourPassword');

        return $this->render($this->viewPrefix . $this->theme . '\auth\reset-password', $this->viewData);

    }

    /**
     * Verifies the code with the email and saves the new password,
     * if they all pass validation.
     *
     * @return mixed
     */
    public function attemptReset()
    {
        if ($this->request->isAJAX()) {

            if ($this->config->activeResetter === false) {
                return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
            }

            $users = model(UserModel::class);

            // First things first - log the reset attempt.
            $users->logResetAttempt( 
                $this->request->getPost('email'),
                $this->request->getPost('tokenHash'),
                $this->request->getIPAddress(),
                (string) $this->request->getUserAgent()
            );

            $rules = [
                'tokenHash' => 'required',
                'email'     => 'required|valid_email'
            ];

            if (!$this->validate($rules)) {
                return $this->getResponse(['error' => $this->validator->listErrors()], 500);
            }

            $rules = [
                'password'         => 'required|strong_password',
                'confirm-password' => 'required|matches[password]',
            ];

           

            if (!$this->validate($rules)) {
                return $this->getResponse(['error' => $this->validator->listErrors()], 500);
            }

            $user = $users->where('email', $this->request->getPost('email'))
                ->where('reset_hash', $this->request->getPost('tokenHash'))
                ->first();

            if (is_null($user)) {
                return $this->getResponse(['error' =>  lang('Auth.forgotNoUser')], 500);
            }

            // Reset token still valid?
            if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
                return $this->getResponse(['error' => lang('Auth.resetTokenExpired')], 500);
            }

            // Success! Save the new password, and cleanup the reset hash.
            $user->password         = $this->request->getPost('password');
            $user->reset_hash         = null;
            $user->reset_at         = date('Y-m-d H:i:s');
            $user->reset_expires    = null;
            $user->force_pass_reset = false;
            $users->save($user);
            session()->remove('wait_valid_two_factor');
            return $this->getResponse(['success' => lang('Auth.resetSuccess')], 200, ['redirect' =>  '/' . env('app.areaAdmin')]);
        }
        return redirect()->to(route_to('reset-password'));
    }

    /**
     * Activate account.
     *
     * @return mixed
     */
    public function activateAccount()
    {
        $users = model('UserModel');

        // First things first - log the activation attempt.
        $users->logActivationAttempt(
            $this->request->getGet('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $throttler = service('throttler');

        if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
            return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $user = $users->where('activate_hash', $this->request->getGet('token'))
            ->where('active', 0)
            ->first();

        if (is_null($user)) {
            return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
        }

        $user->activate();

        $users->save($user);

        return redirect()->route('login-area')->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Resend activation account.
     *
     * @return mixed
     */
    public function resendActivateAccount()
    { 
        if ($this->config->requireActivation === false) {
            return redirect()->route('login-area');
        }

        $throttler = service('throttler');

        if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
            return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $login = urldecode($this->request->getGet('login'));
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $users = model('UserModel');

        $user = $users->where($type, $login)
            ->where('active', 0)
            ->first();

        if (is_null($user)) {
            return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
        }

        $activator = service('activator');
        $sent = $activator->send($user);

        if (!$sent) {
            return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
        }

        // Success!
        return redirect()->route('login-area')->with('message', lang('Auth.activationSuccess'));
    }

    // /**
    //  * Resend activation account.
    //  *
    //  * @return mixed
    //  */
    // public function resendActivateAccount()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->config->requireActivation === false) {
    //             return redirect()->route('login-area');
    //         }

    //         // $throttler = service('throttler');

    //         // if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
    //         //     return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
    //         // }

    //         $throttler =  service('throttler');
    //         if ($throttler->check($this->request->getIPAddress(), 5, MINUTE) === false) {
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' => lang('Auth.tooManyRequests', [$throttler->getTokentime()])

    //             ];
    //             return $this->respond($response, 429);
    //         }


    //         $login = urldecode($this->request->getGet('login-area'));
    //         $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    //         $users = model('UserModel');

    //         $user = $users->where($type, $login)
    //                   ->where('active', 0)
    //                   ->first();

    //         if (is_null($user)) {
    //             //return redirect()->route('login-area')->with('error', lang('Auth.activationNoUser'));
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' =>  lang('Auth.activationNoUser'),
    //             ];
    //             return $this->respond($response);
    //         }

    //         $activator = service('activator');
    //         $sent = $activator->send($user);

    //         if (! $sent) {
    //             //return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
    //             $response = [
    //                 'token' => csrf_hash(),
    //                 'error' => true,
    //                 'message' =>  $activator->error() ?? lang('Auth.unknownError'),
    //             ];
    //             return $this->respond($response);
    //         }

    //         // Success!
    //         //return redirect()->route('login-area')->with('message', lang('Auth.activationSuccess'));
    //         $response = [
    //             'token' => csrf_hash(),
    //             'status' => "success",
    //             'message' => lang('Auth.activationSuccess'),
    //             'redirect' => '/' . env('app.areaAdmin')
    //         ];
    //         return $this->respond($response);
    //     }


    // /**
    //  * Helper method to ensure we always have the info
    //  * we need on every page.
    //  *
    //  * @param string $view
    //  * @param array  $data
    //  */
    // protected function render(string $view, array $data = [])
    // {
    //     $this->response->noCache();
    //     // Prevent some security threats, per Kevin
    //     // Turn on IE8-IE9 XSS prevention tools
    //     $this->response->setHeader('X-XSS-Protection', '1; mode=block');
    //     // Don't allow any pages to be framed - Defends against CSRF
    //     $this->response->setHeader('X-Frame-Options', 'DENY');
    //     // prevent mime based attacks
    //     $this->response->setHeader('X-Content-Type-Options', 'nosniff');

    //     return view($view, $data);
    // }
    

     /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     */
    public function ensureIsNotRateLimited()
    {

        $throttler = service('throttler');

        Events::trigger('lockout', $this->request);
        
        if ($throttler->check($this->throttleKey(), 5, MINUTE) === false) {
            $response = [
                'token' => csrf_hash(),
                'error' => true,
                'message' => lang('Auth.tooManyRequests', [$throttler->getTokentime()])

            ];
            return $this->respond($response, 429);
        }

        return;
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey() {
        return strtolower(str_replace('@', '_', $this->request->getPost('login'))).'|'.$this->request->getIPAddress();
    }

    /***
     * 
     * Display two factor
     * 
     */

     public function displayTwoFactorAuth(){

        Config('Theme')->layout['header']['display'] = false;

        if(user()->two_factor == '2fa_sms'){

            $code = mt_Rand(100000,999999);
            $myTime = new \CodeIgniter\I18n\Time('now');
            $this->user = model(UserModel::class)->with('auth_users_two_factors')->find(user()->id);;
            
            service('session')->set(['2fa_sms_code' => $code, '2fa_sms_code_expiration_at' =>  $myTime->addMinutes(15)]);
            if(!$client  = service('Notification')->sendSms($this->user->auth_users_two_factors[0]->opt_mobile,"Test Notification. Voici votre code : " . $code . " Il expire dans 15 minutes")){
                return $this->getResponse(['error' => lang('Core.sms_no_transmit')], 500);
            }

        }
        return $this->render($this->viewPrefix . $this->theme . '\auth\2fa', $this->viewData);

     }


     public function confirmTwoFactorAuth(){

        if ($this->request->isAJAX()) {

            $code_secret_default = $this->request->getPost('code_secret');
            $action              = $this->request->getPost('action');
            $user                = $this->auth->user();
            $users               = new UserModel();

            if(!is_array($code_secret_default) || empty($code_secret_default) ){
                return $this->getResponse(['error' => lang('Core.Invalid Two Factor Authentication code')], 400);
            }

            $code_secret = implode('', $code_secret_default );

            if(strlen($code_secret) != 6){
                return $this->getResponse(['error' => lang('Core.Invalid Two Factor Authentication code')], 400);
            }

            if($action == '2fa_sms'){

                //ON regarde si c'est ok ? 
                // Reset token still valid?
                $myTime = new \CodeIgniter\I18n\Time('now');
                if ( $myTime >service('session')->get('2fa_sms_code_expiration_at')){
                    return $this->getResponse(['error' => lang('Core.resetTokenExpired')], 400);
                }

                if (service('session')->get('2fa_sms_code') != $code_secret){
                    return $this->getResponse(['error' => lang('Core.Invalid Two Factor Authentication code')], 400);
                }
               
                $user->two_factor_confirmed = 1;
                $users->save($user);
                session()->remove('wait_valid_two_factor');
                return $this->getResponse(['sucess' => lang('Core.Valid Two Factor Authentication code')], 200, ['redirect' => route_to('dashboard')]);

            }else{
                
                $this->google_auth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                $getcode = model(\Adnduweb\Ci4Admin\Models\UserTwoFactorsModel::class)->getCodeTwoFactorSecret(user()->id);

                if ($this->google_auth->checkCode($getcode->two_factor_secret, $code_secret)) {

                    $user->two_factor_confirmed = 1;
                    $users->save($user);
                    session()->remove('wait_valid_two_factor');
                    return $this->getResponse(['sucess' => lang('Core.Valid Two Factor Authentication code')], 200, ['redirect' => route_to('dashboard')]);
                
                }
            }

        }

     }

     /**
      * 
      */
     public function displayCodeRecovery(){

        return $this->render($this->viewPrefix . $this->theme . '\auth\code_recovery', $this->viewData);
        
     }

     /**
      * 
      */
     public function confirmCodeRecovery(){

        if ($this->request->isAJAX()) {

            $code_secret_default = $this->request->getPost('code_secret');
            $user =  $this->auth->user();
            $users = new UserModel();

            if(empty($code_secret_default) ){
                return $this->getResponse(['error' => lang('Core.Invalid Two Factor Authentication code')], 400);
            }

            $getcode = model(\Adnduweb\Ci4Admin\Models\UserTwoFactorsModel::class)->getCodeRecovery(user()->id);

            //print_r($getcode->two_factor_recovery_codes);exit;

            $two_factor_recovery_codes = json_decode(openssl_decrypt($getcode->two_factor_recovery_codes,"AES-128-ECB",config('Encryption')->key));

            if(!in_array($code_secret_default, $two_factor_recovery_codes)){
                return $this->getResponse(['error' => lang('Core.Invalid Code Recovery')], 400);
            }

            $user->two_factor_confirmed = 1;
            $users->save($user);
            session()->remove('wait_valid_two_factor');
            return $this->getResponse(['sucess' => lang('Core.Valid Two Factor Authentication code')], 200, ['redirect' => route_to('dashboard')]);

        }

     }

}
