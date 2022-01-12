<?php 

namespace Adnduweb\Ci4Core\Config;

use CodeIgniter\Config\BaseConfig;

class Language extends BaseConfig
{

    public $supportedLocales = [
        'fr' => [
            'name' => 'Core.french',
            'iso_code' => 'fr',
            'flag' => '/media/flags/france.svg',
        ],
        'en' => [
            'name' => 'Core.english',
            'iso_code' => 'en',
            'flag' => '/media/flags/united-states.svg',
        ]
    ];
    
	
}
