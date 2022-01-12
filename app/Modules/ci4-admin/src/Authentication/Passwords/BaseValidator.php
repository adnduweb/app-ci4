<?php 

namespace Adnduweb\Ci4Admin\Authentication\Passwords;

use Adnduweb\Ci4Admin\Config\Auth as AuthConfig;

class BaseValidator
{
    protected $config;

    /**
     * Allows for setting a config file on the Validator.
     *
     * @param $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

}
