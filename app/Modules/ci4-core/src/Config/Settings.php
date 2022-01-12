<?php 

namespace Adnduweb\Ci4Core\Config;

use Adnduweb\Ci4Core\Handlers\ArrayHandler;
use Adnduweb\Ci4Core\Handlers\DatabaseHandler;

class Settings
{
    /**
     * The available handlers. The alias must
     * match a public class var here with the
     * settings array containing 'class'.
     *
     * @var string[]
     */
    public $handlers = ['database'];

    /**
     * Array handler settings.
     */
    public $array = [
        'class'     => ArrayHandler::class,
        'writeable' => true,
    ];

    /**
     * Database handler settings.
     */
    public $database = [
        'class'     => DatabaseHandler::class,
        'table'     => 'settings',
        'writeable' => true,
    ];
}