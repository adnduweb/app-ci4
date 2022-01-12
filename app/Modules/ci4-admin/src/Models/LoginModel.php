<?php 

namespace Adnduweb\Ci4Admin\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'auth_logins';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'ip_address', 'agent', 'email', 'user_id', 'date', 'success', 'date'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'ip_address' => 'required',
        'email'      => 'required',
        'user_id'    => 'permit_empty|integer',
        'date'       => 'required|valid_date',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    const ORDERABLE = [
        1 => 'ip_address',
        2 => 'email',
        3 => 'date',
    ];

    public static $orderable = ['ip_address', 'email', 'date'];

    /**
     * Stores a remember-me token for the user.
     *
     * @param int    $userID
     * @param string $selector
     * @param string $validator
     * @param string $expires
     *
     * @return mixed
     */
    public function rememberUser(int $userID, string $selector, string $validator, string $expires)
    {
        $expires = new \DateTime($expires);

        return $this->db->table('auth_tokens')->insert([
            'user_id' => $userID,
            'selector' => $selector,
            'hashedValidator' => $validator,
            'expires' => $expires->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Returns the remember-me token info for a given selector.
     *
     * @param string $selector
     *
     * @return mixed
     */
    public function getRememberToken(string $selector)
    {
        return $this->db->table('auth_tokens')
            ->where('selector', $selector)
            ->get()
            ->getRow();
    }

    /**
     * Updates the validator for a given selector.
     *
     * @param string $selector
     * @param string $validator
     *
     * @return mixed
     */
    public function updateRememberValidator(string $selector, string $validator)
    {
        return $this->db->table('auth_tokens')
            ->where('selector', $selector)
            ->update(['hashedValidator' => hash('sha256', $validator)]);
    }


    /**
     * Removes all persistent login tokens (RememberMe) for a single user
     * across all devices they may have logged in with.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function purgeRememberTokens(int $id)
    {
        return $this->builder('auth_tokens')->where(['user_id' => $id])->delete();
    }

    /**
     * Purges the 'auth_tokens' table of any records that are past
     * their expiration date already.
     */
    public function purgeOldRememberTokens()
    {
        $config = config('Auth');

        if (! $config->allowRemembering)
        {
            return;
        }

        $this->db->table('auth_tokens')
                 ->where('expires <=', date('Y-m-d H:i:s'))
                 ->delete();
    }

     /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder =  $this->db->table('auth_logins')
            ->select('*');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('email', $search)
                ->orLike('user_id', $search)
                ->orLike('ip_address', $search)
                ->orLike('date', $search)
            ->groupEnd();

        return $condition;
    }
}
