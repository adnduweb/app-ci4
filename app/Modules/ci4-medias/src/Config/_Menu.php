<?php

namespace Adnduweb\Ci4Medias\Config;

use CodeIgniter\Config\BaseConfig;

class _Menu extends BaseConfig
{

    public $vertical = [ 
            [
                'title' => 'Medias',
                'ancre' => 'medias',
                'path'  => 'medias',
                'icon'  => "icons/duotone/Design/PenAndRuller.svg"
            ],

        ];

        public $position = ["vertical" => '1'];
        
        public $module = true;

        public $collection = 'module';

}