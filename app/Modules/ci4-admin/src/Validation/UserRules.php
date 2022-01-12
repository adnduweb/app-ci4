<?php

namespace Adnduweb\Ci4Admin\Validation;

use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Admin\Libraries\Password;
use Exception;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByEmailAddress($data['email']);
            //print_r( $user ); exit;
            if (! Password::verify(service('request')->getVar('password'), $user->password_hash)){
                // return $this->fail('Wrong Password');
                //throw new Exception('Wrong Password.');
            }
                 
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}


// namespace App\Validation;

// class CustomRules{
    
//     /**
//     * Rule is to validate birthday
//     * @param string $str
//     * @param string $fields
//     * @param array $data
//     * @param string $error
//     * @return boolean
//     */
//     public function birthdayValidation(string $str = null, string $fields = null, array $data = [], string &$error = null) {
    
//         if(empty($data['month']) || empty($data['day']) || empty($data['year'])) {
//             return true;
//         }
        
//         $birthDay = $data['year'].'-'.$data['month'].'-'.$data['day'];
        
//         if(!checkdate($data['month'], $data['day'], $data['year'])) {
//             $error = "The Birthday field is not a valid date.";
//             return false;
//         }
        
//         if (time() < strtotime('+18 years', strtotime($birthDay))) {
//             $error = "You must be at least 18 years old.";
//             return false;
//         }
        
//         if (time() > strtotime('+99 years', strtotime($birthDay))) {
//             $error = "The age may not be greater than 99 years.";
//             return false;
//         }
        
//         return true;
//     }
    
// } 