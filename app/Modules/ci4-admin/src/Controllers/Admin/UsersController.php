<?php

namespace Adnduweb\Ci4Admin\Controllers\Admin;

use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use Illuminate\Support\Str;
use Adnduweb\Ci4Core\Traits\LibphoneTraits;
use Adnduweb\Ci4Core\Traits\ExportData;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Core\Models\SessionModel;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Admin\Models\UserTwoFactorsModel;
use Adnduweb\Ci4Admin\Models\UserAdresseModel;
use CodeIgniter\API\ResponseTrait;

use DataTables;

class UsersController extends \Adnduweb\Ci4Admin\Controllers\BaseAdminController
{
    use ResponseTrait; 
    use LibphoneTraits;
    use ExportData;


    /**  @var string  */
    protected $uuidUser;

    /**  @var string  */
    protected $table = "users";

    /**  @var string  */
    protected $className = "User";

    /**  @var string  */
    public $path = "\Adnduweb\Ci4Admin";

    /**  @var string  */
    protected $viewPrefix = 'Adnduweb\Ci4Admin\Views\themes\\';

    /**  @var string  */
    public $category  = 'settings-advanced';

    /**  @var object  */
    public $tableModel = UserModel::class;

    /**  @var string  */
    public $identifier_name = 'lastname';

     /**  @var object  */
     public $google_auth;

     public function __construct(){

        $this->viewData['google_auth'] = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
     }


    /**
     * Displays a list of available.
     *
     * @return string
     */
    public function index(): string
    {
        helper('time');
        $this->viewData['meta_title'] = lang('User.meta_title') ;
        $this->viewData['meta_description'] = lang('User.meta_description') ;

        Theme::add_js('plugins/custom/datatables/datatables.bundle.js');
    
        $this->viewData['users'] = model(UserModel::class)->get_all_users();

        //print_r($this->viewData['users']); exit;
        parent::index();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\users\index', $this->viewData);
    }

    /**
     * Shows details for one item.
     *
     * @param string $itemId
     *
     * @return string
     */
    public function edit(string $uuid): string
    {
        Config('Theme')->layout['subheader']['display'] = false;
        Config('Theme')->layout['subheader']['display_form'] = true;

        helper(['tools', 'time']);

        parent::edit($uuid); 


        if (has_permission(ucfirst($this->className) . '-editOnly', user()->id) && user()->uuid != $uuid && isSuperUser() == false) {
            Theme::set_message('danger', lang('Auth.notEnoughPrivilege'), lang('Core.warning_error'));
            return redirect()->to(route_to('dashboard'));
        }


        $this->viewData['title_detail'] = $this->object->lastname  . ' ' . $this->object->fistname;

        //Get Permissions User
        $this->getPermissions($this->object->id);

        // var_dump($this->object->isSuperHero());


        // List of groups
        $this->google_auth = $this->viewData['groups'] = $this->tableModel->getGroups();
        //$this->object->sessions = $this->object->getSessions();
        $this->object->logs = $this->object->getlastLogs();

        //List Of Company 
        $this->object->company = $this->tableModel->getCompany(); 

        $this->viewData['form'] = $this->object;

        return $this->render($this->viewPrefix . $this->theme . '/\pages\users\form', $this->viewData);
    }

    /**
     * Displays the form for a new item.
     *
     * @return string
     */
    public function new(): string
    {
        helper('tools');
       //parent::create();

        // Initialize form
        $this->viewData['form'] = new User();
        $this->viewData['groups'] = $this->tableModel->getGroups();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\users\new_form', $this->viewData);
    }

    /**
     * Creates a item from the new form data.
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {

        // validate
        // Validate basics first since some password rules rely on these fields
		$this->rules = [
			'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
			'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($this->rules)) {
            Theme::set_message('error', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }

        // Validate passwords since they can only be validated properly here
		$rules = [
			'password'     => 'required|strong_password',
			'pass_confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
            Theme::set_message('error', $this->validator->getErrors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }     
        
        // Try to create the item
        $user = new User($this->request->getPost());
        $user->username = ucfirst(trim(strtolower($user->firstname))) . ucfirst($user->lastname[0]) . time();
        $user->force_pass_reset = ($user->force_pass_reset == '1') ? $user->force_pass_reset : '0';
        $user->uuid = $this->uuid->uuid4()->toString();


        // Activation direct
        if (!$this->request->getPost('requireactivation')) {
            $user->active = 1;
        }

        // On envoi un code d'activation à l'utilisateur
        if ($this->request->getPost('requireactivation')) {

            $user->generateActivateHash();
            $user->deactivate();
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                Theme::set_message('danger', $activator->error(), lang('Auth.unknownError'));
                return redirect()->back()->withInput();
            }
        }


        model(UserModel::class)->withGroup($this->request->getPost('group'));
        
        if (! $userId = model(UserModel::class)->save($user)) {
            Theme::set_message('error', model(GroupModel::class)->errors(), lang('Core.warning_error'));
            return redirect()->back()->withInput();
        }
    
        // Success!
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->to($this->path_redirect . '/edit/' . $user->uuid  . '?token=' . $this->token );

    }

    

    /**
     * Update item details. https://www.positronx.io/codeigniter-rest-api-tutorial-with-example/
     * 
     *
     * @return RedirectResponse
     */
    public function updateAjax(): ResponseInterface
    {
        parent::updateAjax();

        switch ($this->object->id) {
            case $this->object->id == user()->id:
                return $this->getResponse(['error' => lang('Core.not_delete_propre_compte')], 403);
                break;
            case $this->object->id == 1:
                return $this->getResponse(['error' => lang('Core.not_delete_principal_compte')], 403);
                break;
            case (!inGroups(1, user()->id) && inGroups(1, $this->object->id)):
                return  $this->getResponse(['error' => lang('Core.not_delete_superuser_compte')], 403);
                break;
        }
 
        if($this->object->active == 0){
            $this->object->activate();
        }else{
            $this->object->deactivate();
        }

        if(!model(UserModel::class)->save($this->object)){
            return $this->failure(400, 'No user save', true);
        }

        return $this->getResponse(['success' => 'User updated successfully'], 200);
        
    }

            /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function delete(): ResponseInterface
    {

        //print_r($this->request->getRawInput('id')); exit;

        if ($this->request->isAJAX()) {

            $response = json_decode($this->request->getBody());

             if(!is_array($response->uuid))
             return false; 

                $itsme = false;
                $comptePrincipal = false;
                $notAccesSuperUser = false;
                foreach ($response->uuid as $key => $uuid) {
                    $user_uuid = $this->uuid->fromString($uuid)->getBytes();
                    if(!$this->obj = model(UserModel::class)->where('uuid', $user_uuid)->first()){
                        $this->getResponse(['error' => PageNotFoundException::forPageNotFound()], 404);
                    }

                    switch ($this->obj->id) {
                        case $this->obj->id == user()->id:
                            $itsme = true;
                            break;
                        case $this->obj->id == 1:
                            $comptePrincipal = true;
                            break;
                        case (!inGroups(1, user()->id) && inGroups(1, $this->obj->id)):
                            $notAccesSuperUser = true;
                            break;
                    }

                    $this->tableModel->delete($this->obj->id);
                }

            if ($itsme == true) {
                    return $this->getResponse(['error' => lang('Core.not_delete_propre_compte')], 403);
            } elseif ($comptePrincipal == true) {
                return $this->getResponse(['error' => lang('Core.not_delete_principal_compte')], 403);
            } elseif ($notAccesSuperUser == true) {
                return  $this->getResponse(['error' => lang('Core.not_delete_superuser_compte')], 403);
            } else {
                
                return $this->getResponse(['success' => lang('Core.your_selected_records_have_been_deleted')], 200);
            }
        
        }
        return $this->getResponse(['success' => lang('Core.no_content')], 204);
       
    }


    /**
     * Get permission
     * 
     * @param string $user_id
     *
     * @return array
     */
    protected function getPermissions($user_id = null) : array
    {

        $permissionModel = new \Adnduweb\Ci4Admin\Models\PermissionModel();

        // On récupére les permissions du groupe ou des groupes
        foreach ($this->object->auth_groups_users as $groups) {
            $permissionByIdGroupGroup       = $permissionModel->getPermissionsByIdGroup($groups->group_id);
            $this->viewData['permissionByIdGroupGroup'][$groups->group_id] = [];
            if (!empty($permissionByIdGroupGroup)) {
                foreach ($permissionByIdGroupGroup as $permissions) {
                    $this->viewData['permissionByIdGroupGroup'][$permissions->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
            $permissionByIdGroupGroupUser       = $permissionModel->permissionByIdGroupGroupUser($groups->group_id);
            $this->viewData['permissionByIdGroupGroupUser'][$groups->group_id] = [];
            if (!empty($permissionByIdGroupGroupUser)) {
                foreach ($permissionByIdGroupGroupUser as $permissions) {
                    $this->viewData['permissionByIdGroupGroupUser'][$groups->group_id][$permissions->permission_id] = $permissions->permission_id;
                }
            }
        }

        if (!is_null($user_id)) {
            //$this->viewData['getSessionsUser'] = $this->auth->getSessionsUser();
            $this->viewData['getSessionsUser'] = model(SessionModel::class)->getSessionsUser($user_id);
        }


        // On récupérer les permissions
        $this->viewData['permissions']   = $permissionModel->getPermission();

        // Si je ne suis pas un super user et que je modifie mon compte
        if (!inGroups(1, user()->id) && user()->id == $this->object->id) {
            foreach ($this->object->auth_groups_users as $auth_groups_users) {
                $this->viewData['id_group'] = $auth_groups_users->group_id;
            }
        }

        return $this->viewData;
    }

    /**
     * 
     */
    public function workCrudGroup($user)
    {
        $groupModel = new  \Adnduweb\Ci4Admin\Models\GroupModel();
        $user->groups =  $groupModel->getGroupsForUserLight($user->id);

        //print_r($user->groups); exit;

        //it's me je suis sur mon compte
        if (user()->id == $user->id) {

            // Si je suis super admin et je dois rester super admin.
            $idGroupCurrent = array_flip($this->request->getPost('id_group'));
            $firstKey = array_key_first($user->groups);

            if (!isset($idGroupCurrent[$firstKey])) {
                return ['status' => 422, 'message' => lang('Core.not_change_group_principal')];
            }

            foreach ($user->groups as $k => $v) {
                if (!isset($idGroupCurrent[$k])) {
                    $groupModel->removeUserFromGroup($user->id, $k);
                }
            }

            foreach ($idGroupCurrent as $k => $v) {
                if (!isset($user->groups[$k])) {
                    $groupModel->addUserToGroup($user->id, $k);
                }
            }
        } else {

            // //ce n'est pas moi
            $idGroupCurrent = array_flip($this->request->getPost('id_group'));

            //print_r($idGroupCurrent); exit;

            $groupModel->removeUserFromAllGroups($user->id);
            foreach ($idGroupCurrent as $k => $v) {
                //if (!isset($user->groups[$k])) {
                    $groupModel->addUserToGroup($user->id, $k);
               // }
            }
        }
        return true;
    }

    // protected function saveSettings(array $posts)
    // {

    //     $setting_notification_email = (!isset($posts['setting_notification_email'])) ? false : true;
    //     $setting_notification_sms = (!isset($posts['setting_notification_sms'])) ? false : true;
    //     $setting_connexion_unique = (!isset($posts['setting_connexion_unique'])) ? false : true; 
    //     cache()->delete(config('Cache')->prefix . "settings-contents-{$setting_notification_email}-".user()->id);
    //     cache()->delete(config('Cache')->prefix . "settings-contents-{$setting_notification_sms}-".user()->id);
    //     cache()->delete(config('Cache')->prefix . "settings-contents-{$setting_connexion_unique}-".user()->id);
    //     service('Settings')->setting_notification_email = $setting_notification_email;
    //     service('Settings')->setting_notification_sms = $setting_notification_sms;
    //     service('Settings')->setting_connexion_unique = $setting_connexion_unique;
    // }

    // public function ktAsideUser()
    // {
    //     $post = $this->request->getPost();
    //     if ($this->request->isAJAX()) {

    //         cache()->delete(config('Cache')->prefix . 'settings-contents-setting_aside_back-' . user()->id);
    //         service('settings')->get('App.mode_bo', 'dark') = ($post['aside'] == '0') ? '1' : '0';
    //     }
    //     die(1);
    // }

    public function deleteSession()
    {
        $data = $this->request->getVar(); // all form data into $data variable

        $data['deleteSessionUserOther'] = model(SessionModel::class)->deleteSessionUserOther(user()->id, session_id());
      
        return make_json( array( 
           "success" => true, 
           csrf_token() => csrf_hash(),
           "message" => "Session supprimé", 
           "data" => $data 
        ));
    }


    /**
     * Save item details Ajax.
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function save()
    {
        if ($this->request->isAJAX()) {

            $this->id = $this->request->getPost('uuid');
            $action = $this->request->getPost('action');
            
            $this->obj = $this->loadObject(true);

            if (!is_object($this->obj))
                return false;

            switch ($action) {
                case 'edit_user':

                        $this->rules = [
                            'email'    => 'required|valid_email|is_unique[users.email,id,' . $this->request->getPost('id') . ']',
                        ];
            
                        if (!$this->validate($this->rules)) {
                            return $this->getResponse(['error' => $this->validator->getErrors()], 422);
                        }
        
                        // try to update the item
                        $user = $this->request->getPost();
                        if (! model(UserModel::class)->update($this->obj->id, $user)) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                        // try to update the item
                        $address = $this->request->getPost('address');
                        
                        if(!empty($address['id'])){
                            $address['updated_at']     = date('Y-m-d H:i:s');
                            if (! model(UserAdresseModel::class)->update($address['id'], $address)) {
                                return $this->getResponse(['error' => model(UserAdresseModel::class)->errors()], 500);
                            }
                        }else{
                            $address['user_id']    = $this->obj->id;
                            $address['country_id'] = empty($address['country_id']) ? 74 : $address['country_id'];
                            $address['created_at'] = date('Y-m-d H:i:s');

                               if (! $address['id'] = model(UserAdresseModel::class)->insert($address, true)) {
                                return $this->getResponse(['error' => model(UserAdresseModel::class)->errors()], 500);
                            }
                        }
                       
                        // Success!
                        $let = [ 
                            'address_id' => $address['id'],  
                            'display_kt_user_view_details' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_user_view_details', ['form' => $this->obj]),
                            ];
                        return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);
    
                    break;
                case 'edit_user_email':

                        $this->rules = [
                            'email'    => 'required|valid_email|is_unique[users.email,id,' . $this->request->getPost('id') . ']',
                        ];
            
                        if (!$this->validate($this->rules)) {
                            return $this->getResponse(['error' => $this->validator->getErrors()], 422);
                        }
        
                        // try to update the item
                        $user = $this->request->getPost();
                        if (! model(UserModel::class)->update($this->obj->id, $user)) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                         // Success!
                         $let = [ 
                             'display_kt_user_view_details' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_user_view_details', ['form' => model(UserModel::class)->find($this->obj->id)]),
                             'display_kt_table_users_profile' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_table_users_profile', ['form' => model(UserModel::class)->with('auth_groups_users')->find($this->obj->id)])
                            ];

                             return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);
     

                    break;
                case 'edit_user_phone':

                    $address           = $this->request->getPost('address');
                    $inter_phone       = $this->request->getPost('phone');
                    $prefix_code_phone = $this->request->getPost('prefix_code_phone');
                    $iso2_code_phone   = $this->request->getPost('iso2_code_phone');

                    $inter_phone_mobile       = $this->request->getPost('phone_mobile');
                    $prefix_code_phone_mobile = $this->request->getPost('prefix_code_phone_mobile');
                    $iso2_code_phone_mobile   = $this->request->getPost('iso2_code_phone_mobile');


                    if (! $inter_phone_mobile) {
                        return $this->getResponse(['error' => lang('Core.not_phone_mobile')], 422);
                    }
                    if(!empty($inter_phone)){
                        $phone  = $this->phoneInternational($inter_phone, $iso2_code_phone);
                        if($phone['status'] != 200 ){
                            return $this->getResponse(['error' => $phone['message']], $phone['status']);
                        }
                        $address['phone'] = $phone['message'];
                    }
                   
                    $phone_mobile = $this->phoneInternational($inter_phone_mobile, $iso2_code_phone_mobile);
                    if($phone_mobile['status'] != 200 ){
                        return $this->getResponse(['error' => $phone_mobile['message']], $phone['status']);
                    }

                    
                    // try to update the item
                    $address['phone_mobile'] = $phone_mobile['message'];
                    $adressId = $this->saveAdresse($address);

                    // Success!
                    $let = [
                        'address_id' => $adressId,  
                        'display_kt_table_users_profile' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_table_users_profile', ['form' => model(UserModel::class)->with('auth_groups_users')->find($this->obj->id)])
                    ];
                    return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);

                    break;
                case 'edit_user_password':
                        //Vérification du mot de passe
                        $password     = $this->request->getPost('new_password');
                        $pass_confirm = $this->request->getPost('confirm_password');
    
                        if ($this->auth->validate(['email' => $this->obj->email, 'password' => trim($this->request->getPost('current_password') )] )  == false) { 
                            return $this->getResponse(['error' => lang('Core.bad_password')], 422);
                            
                        }

                        if (!empty($password)) { 
                            if ($password != $pass_confirm) {
                                return $this->getResponse(['error' => lang('Core.not_concordance_mote_de_passe')], 422);
                            }
                        }
                        //$user = new User($this->request->getPost($allowedPostFields));
                        //$user = new User( array_merge($this->request->getPost(), ['password' => $password]) );
                        $this->obj->setPassword(trim($password));
                        //print_r($this->obj); exit;

                        // try to update the item
                        $user = $this->request->getPost();
                        if (! model(UserModel::class)->save($this->obj)) {
                             return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                         // Success!
                         $let = [ 
                            'display_kt_user_view_details' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_user_view_details', ['form' => model(UserModel::class)->find($this->obj->id)])
                        ];
                         return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);

                    break;
                case 'edit_user_group':

                        $workCrudGroup = $this->workCrudGroup($this->obj);
                        
                        if(isset($workCrudGroup['status'])){
                            if ($workCrudGroup['status'] == 422) {
                                return $this->getResponse(['error' => $workCrudGroup['message']], 422);
                            }      
                        }                  

                        // Success!
                        return $this->getResponse(['success' => lang('Core.saved_data')], 200);

                    break;

                case 'edit_user_2fa_auth':

                    $secret = $this->request->getPost('secret');
                    $code   = $this->request->getPost('2fa')['code'];

                    //echo '-faridvsvsdv'; exit;

                    $this->google_auth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

                    if ($this->google_auth->checkCode($secret, $code)) {
                        // Success!
                        $codeRecovery = $this->recoveryCode(8);
                        //echo $this->obj->id; exit;
                        //delete old 2fa
                        model(UserTwoFactorsModel::class)->where('user_id', $this->obj->id)->delete();

                        //echo $this->obj->id; exit;

                        //print_r($user); exit;
                        if (! model(UserModel::class)->update($this->obj->id, ['two_factor' => '2fa'])) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                       // echo '<div class="alert alert-">'; exit;

                        $user_two_factor = [
                            'user_id' => $this->obj->id, 
                            'two_factor_secret' => $secret, 
                            'two_factor_recovery_codes' => openssl_encrypt(json_encode($codeRecovery), "AES-128-ECB", config('Encryption')->key), 
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        //print_r($user_two_factor); exit;

                        if (! model(UserTwoFactorsModel::class)->insert($user_two_factor, true)) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                        $let = [ 
                            'display_auth_two_step_list' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_auth_two_step_list', ['form' => model(UserModel::class)->find($this->obj->id)]),
                            'codeRecovery' => $codeRecovery
                        ];

                        return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);
                    }else{
                        $response = ['code' => 400, 'message' =>lang('Core.oups not_OPT'),'success' => false, csrf_token() => csrf_hash()];
                        return $this->respond($response, 400);
                    }

                    //https://www.codekayak.net/make-two-factor-authentication-laravel/


                break;

                case 'edit_user_2fa_sms':

                    $inter_phone_mobile       = $this->request->getPost('otp_mobile');
                    $prefix_code_phone_mobile = $this->request->getPost('prefix_code_phone_mobile');
                    $iso2_code_phone_mobile   = $this->request->getPost('iso2_code_phone_mobile');
                    $addVerifTel              = $this->request->getPost('addVerifTel');
                    $addVerifCode             = $this->request->getPost('addVerifCode');

                    $phone_mobile = $this->phoneInternational($inter_phone_mobile, $iso2_code_phone_mobile);
                    if($phone_mobile['status'] != 200 ){
                        return $this->getResponse(['error' => $phone_mobile['message']], $phone_mobile['status']);
                    }
                    

                    if($addVerifTel){
                    
                        $code = mt_Rand(100000,999999);
                        $myTime = new \CodeIgniter\I18n\Time('now');
                        service('session')->set(['2fa_sms_code' => $code, '2fa_sms_code_expiration_at' =>  $myTime->addMinutes(15)]);
                        if($client  = service('Notification')->sendSms(trim($phone_mobile['message']),"Test Notification. Voici votre code : " . $code . " Il expire dans 15 minutes")){
                            return $this->getResponse(['success' => lang('Core.Test Notification')], 200, ['sendSms' => true]);
                        }

                        return $this->getResponse(['error' => $client], 500);
                    }

                    if($addVerifCode){
 
                        $current = new \CodeIgniter\I18n\Time('now');
                        $fa_sms_code_expiration_at    = service('session')->get('2fa_sms_code_expiration_at');
                        $diff = $current->difference($fa_sms_code_expiration_at);

                        // On regarde l'égalité
                        if(service('session')->get('2fa_sms_code') != trim($this->request->getPost('code_secret'))){
                            return $this->getResponse(['error' => lang('Core.Code Error')], 500);
                        }

                        // On regenére un autre code
                        if($diff->getMinutes() <= 0){
                            return $this->getResponse(['error' => lang('Core.Code expired')], 500, ['regenereCode' => true]);
                        }

                        //delete old 2fa
                        model(UserTwoFactorsModel::class)->where('user_id', $this->obj->id)->delete();

                        if (! model(UserModel::class)->update($this->obj->id, ['two_factor' => '2fa_sms'])) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }


                        $user_two_factor = [
                            'user_id' => $this->obj->id, 
                            'type' => '2fa_sms',
                            'opt_mobile' => $phone_mobile['message'], 
                            'is_verified' => true, 
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        //print_r($user_two_factor); exit;

                        if (! model(UserTwoFactorsModel::class)->insert($user_two_factor, true)) {
                            return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                        }

                        $let = [ 
                            'display_auth_two_step_list' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_auth_two_step_list', ['form' => model(UserModel::class)->find($this->obj->id)])
                        ];
                        return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);
                    }

                break;

                case 'edit_user_2fa_email':

                    $secret     = $this->request->getPost('secret');
                    $code = $this->request->getPost('2fa')['code'];

                    $this->google_auth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

                    if ($this->google_auth->checkCode($secret, $code)) {
                        // Success!
                        $codeRecovery = $this->recoveryCode(8);

                        $user = ['two_factor_secret' => $secret, 'two_factor_recovery_codes' => openssl_encrypt(json_encode($codeRecovery), "AES-128-ECB", config('Encryption')->key)];
                        //print_r($user); exit;
                        if (! model(UserModel::class)->update($this->obj->id, $user)) {
                            $response = ['code' => 500, 'messages' => model(UserModel::class)->errors(), 'success' => false, csrf_token() => csrf_hash()];
                            return $this->respond($response, 500);
                        }

                        $response = [ 'success' =>['code' => 200, 'message' => lang('Core.saved_data')],  'codeRecovery' => $codeRecovery, 'error' => false, csrf_token() => csrf_hash()];
                        return $this->respond($response);
                    }else{
                        $response = ['code' => 400, 'message' =>lang('Core.oups not_OPT'),'success' => false, csrf_token() => csrf_hash()];
                        return $this->respond($response, 400);
                    }

                    //https://www.codekayak.net/make-two-factor-authentication-laravel/


                break;

                case 'edit_user_notification':

                    $connexionUnique = $this->request->getPost('connexionUnique');
                    $force_pass_reset = $this->request->getPost('force_pass_reset');

                    service('settings')->connexionUnique = ($connexionUnique == '1') ? 1 : 0;

                    $this->obj->generateResetHash();
                    $this->obj->force_pass_reset = $force_pass_reset;
                    
                    //if (! model(UserModel::class)->update($this->obj->id, ['force_pass_reset' => $force_pass_reset])) {
                    if (! model(UserModel::class)->save($this->obj)) {
                        return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
                    }

                    return $this->getResponse(['success' => lang('Core.saved_data')], 200);

                break;


                default:
                return $this->respondNoContent();
            }


        }

        return $this->respondNoContent();
    }

    /**
     * SAVE ADDRESSE
     */
    protected function saveAdresse($address){

        if(!empty($address['id'])){
            $address['updated_at']     = date('Y-m-d H:i:s');
            if (! model(UserAdresseModel::class)->update($address['id'], $address)) {
                return $this->getResponse(['error' => model(UserAdresseModel::class)->errors()], 500);
            }
        }else{
            $address['user_id']    = $this->obj->id;
            $address['country_id'] = empty($address['country_id']) ? 74 : $address['country_id'];
            $address['created_at'] = date('Y-m-d H:i:s');

            if (! $address['id'] = model(UserAdresseModel::class)->insert($address, true)) {
                return $this->getResponse(['error' => model(UserAdresseModel::class)->errors()], 500);
            }
        }
        return $address['id'];
    }

    /**
     * 
     */
    public function detete2Fa(){

        if ($this->request->isAJAX()) {

            $response = json_decode($this->request->getBody());
            $user_id = $response->user_id;
            $user_uuid = $this->uuid->fromString($user_id)->getBytes();
            $this->obj = model(UserModel::class)->where('uuid', $user_uuid)->first();

            //delete old 2fa
            model(UserTwoFactorsModel::class)->where('user_id', $this->obj->id)->delete();

             //print_r($user); exit;
             if (! model(UserModel::class)->update($this->obj->id, ['two_factor' => ''])) {
                return $this->getResponse(['error' => model(UserModel::class)->errors()], 500);
            }

            $let = [ 
                'display_auth_two_step_list' => view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_auth_two_step_list', ['form' => model(UserModel::class)->find($this->obj->id)])
            ];
            return $this->getResponse(['success' => lang('Core.saved_data')], 200, $let);

        }
        return $this->respondNoContent();

    }

    public function deleteSessions( string $uuid){

        $user_uuid = $this->uuid->fromString($uuid)->getBytes();
        if(!$this->obj = model(UserModel::class)->where('uuid', $user_uuid)->first()){
            throw PageNotFoundException::forPageNotFound();
        }

        model(SessionModel::class)->where('user_id=' . $this->obj->id . ' AND id !="' . session_id() . '"')->delete();

        Theme::set_message('success', lang('Core.deleted_data'), lang('Core.cool_success'));
         return redirect()->to($this->path_redirect . '/edit/' . $this->obj->uuid);
    }

    /**
     * 
     */
    public function recoveryCode(int $number){

        $tab =[];
        for ($i = 1; $i <= $number; $i++) {
            $tab[] = Str::random(10).'-'.Str::random(10); 
        }

        return $tab;
    }

     /**
     * Export the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function export($format = null)
    {

        $response = json_decode($this->request->getBody());

        if(!$response->format){
            return $this->getResponse(['error' => lang('Core.not_choice')], 422);
            exit;
        }

        // ON définit le header et les données pour $header = array_merge(model(GroupModel::class)::$orderable, ['created_at']);
        $this->headerExport = array_merge( ['id', 'uuid'], model(UserModel::class)::$orderable);
        $this->dataExport = model(UserModel::class)->asArray()->select(implode(',', $this->headerExport))->findAll();

        switch ($response->format) {
            case 'excel':
                if ($this->request->isAJAX()) {
                    $exportXls  = $this->exportXls($this->className, strtolower($this->className).'-'.time().'.xlsx', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/vnd.ms-excel;base64,".base64_encode($exportXls)]);

                }else{
                    $exportXls  = $this->exportXls($this->className, strtolower($this->className).'-'.time().'.xlsx', false);
                    exit;
                    } 
                
                break;
            case 'csv':
                if ($this->request->isAJAX()) {
                    $exportCsv  = $this->exportCsv('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/csv;base64,".base64_encode($exportCsv)]);
                    exit;

                }else{
                    $exportCsv  = $this->exportCsv('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv', false);
                    exit;
                }
                break;
            case 'pdf':
                if ($this->request->isAJAX()) {
                    $this->viewData['header'] =  $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;
                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', true);
                    return $this->getResponse(['success' => lang('Core.download_file')], 200, [ 'op' => 'ok', 'file' => "data:application/pdf;base64,".base64_encode($exportPdf->output())]);
                    exit;

                }else{
                    $this->viewData['header'] =  $this->headerExport;
                    $this->viewData['data'] = $this->dataExport;
                    $exportPdf  = $this->exportPdf('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf', 'A4', 'portrait', false);
                    exit;
                }
    
                break;
            default:
                return $this->getResponse(['error' => lang('Core.not_choice')], 422);
        }
       
    }

    /**
     * Displays the form for a new item.
     *
     * @return string
     */
    public function enTantQue(): string
    {
        helper('tools');
       //parent::create();

        // Initialize form
        $this->viewData['form'] = new User();

        return $this->render($this->viewPrefix . $this->theme . '/\pages\users\entantque', $this->viewData);
    }

    /**
     * Creates a item from the new form data.
     *
     * @return CodeIgniter\Http\Response
     */
    public function confirmEnTantQue(): ResponseInterface
    {

        $response = json_decode($this->request->getBody());
        
        $user_uuid = $this->uuid->fromString($response->uuid)->getBytes();
        if(!$this->obj = model(UserModel::class)->where('uuid', $user_uuid)->first()){
            throw PageNotFoundException::forPageNotFound();
        }

        if($response->uuid == $this->session->get('entantque')){
            $this->session->remove('entantque');
        }else{
            $data = ['entantque' => user()->uuid];
            $this->session->set($data);
        }

      
        service('authentication')->updateCompte($this->obj);
       
        return $this->getResponse(['success' => lang('Core.no_content')], 204);

    }


    public function listUser(){

        $search = $this->request->getGet('s');
        $list = $this->convertBinToUuid($this->tableModel->getResource($search)->orderBy('lastname', 'ASC')->get()->getResultObject());

        $response =[
            'display_kt_search_users_element' => view('Adnduweb\Ci4Admin\themes\\'. $this->theme .'\pages\users\__partials\_search_users', ['list_users' => $list] ), 
            'count' => count($list)
        ];

        return $this->getResponse([], 200,  $response );
    }

    public function returnCompteUser(string $uuid){

        $user_uuid = $this->uuid->fromString($uuid)->getBytes();
        if(!$this->obj = model(UserModel::class)->where('uuid', $user_uuid)->first()){
            throw PageNotFoundException::forPageNotFound();
        }

        $this->session->remove('entantque');
        service('authentication')->updateCompte($this->obj);
       
        Theme::set_message('success', lang('Core.saved_data'), lang('Core.cool_success'));
        return redirect()->back();
    }
}
