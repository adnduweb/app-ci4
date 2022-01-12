<?php

namespace Adnduweb\Ci4Core\Config;

/**
 * Class BaseModule
 *
 * Provides a foundation for module configuration files.
 *
 * @package Bonfire\Config
 */
class BaseModule
{
    /**
     * During system boot for the admin area, this method
     * is called on all module config classes, allowing them
     * to perform any setup necessary, like hooking into the
     * sidebar menu, etc.
     */
    public function initAdmin()
    {
    }

    /**
     * During system boot for the front end, this method
     * is called on all module config classes, allowing them
     * to perform any setup necessary.
     */
    public function initFront()
    {
        return;
    }

    public $version = '1.2.0';
}
