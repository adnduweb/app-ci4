<?php

namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Config\BaseConfig;

class Menu extends BaseConfig
{

    public $dashboard = [

        [
            'title' => 'Core.dashboard',
            'path'  => 'dashboard',
            'icon'  => "icons/duotone/Design/PenAndRuller.svg"
        ]
    ];

    public $vertical = [
            // Main menu
           

            //// Modules
            array(
                'classes' => array('content' => 'pt-8 pb-2'),
                'ancre'   => "system",
                'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Systéme</span>',
            ),

         
            // System
            [
                'title'      => 'Users',  
                'icon'       => array(
                    'svg'  => "icons/duotone/Layout/Layout-4-blocks.svg",
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ),
                'classes'    => array('item' => 'menu-accordion'),
                'segment'      => "settings-advanced",
                'ancre'      => 'users',
                'attributes' => array(
                    "data-kt-menu-trigger" => "click",
                ),
                'sub'        => array(
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => array(
                        array(
                            'title'      => 'Users',
                            'ancre'      => "users",
                            'path'       => 'settings-advanced/users',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),

                        array(
                            'title'      => 'Permissions',
                            'ancre'      => "permissions",
                            'path'       => 'settings-advanced/permissions',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),
                        array(
                            'title'      => 'Rôles',
                            'ancre'      => "groups",
                            'path'       => 'settings-advanced/groups',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),
                    ),
                ),
            ],

            array(
                'title'      => 'Settings',
                'ancre'      => "settings",
                'path'       => 'settings-advanced/settings',
                'icon'  => "icons/duotone/Design/PenAndRuller.svg"
            ),

             // Logs
             [
                'title'      => 'Logs',  
                'icon'       => array(
                    'svg'  => "icons/duotone/Layout/Layout-4-blocks.svg",
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ),
                'classes'    => array('item' => 'menu-accordion'),
                'segment'    => "settings-advanced",
                'ancre'      => "logs",
                'attributes' => array(
                    "data-kt-menu-trigger" => "click",
                ),
                'sub'        => array(
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => array(
                        array(
                            'title'      => 'Audit Log',
                            'ancre'      => "logs",
                            'path'       => 'settings-advanced/logs',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),
                        array(
                            'title'      => 'Informations',
                            'ancre'      => "informations",
                            'path'       => 'settings-advanced/informations',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),
                        array(
                            'title'      => 'Traductions',
                            'ancre'      => "translates",
                            'path'       => 'settings-advanced/translates',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                        ),
                    ),
                ),
            ],
           
            [
                'title'      => 'Modules',
                'ancre'      => "modules",
                'path'       => 'settings-advanced/modules',
                'icon'  => "icons/duotone/Design/PenAndRuller.svg"
            ],

            // Separator
            array(
                'content' => '<div class="separator mx-1 my-4"></div>',
            ),

            // Changelog
            array(
                'title' => 'Changelog __v__',
                'icon'  => "icons/duotone/Files/File.svg",
                'path'  => 'changelog',
            )
        ];

        public $horizontal = [

             
                // Resources
                array(
                    'title'             => 'Cache',
                    'restrict'          => true,
                    'menu-link-classes' => 'btn btn-light-primary font-weight-bolder btn-sm',
                    'classes'           => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
                    'attributes'        => array(
                        'data-kt-menu-trigger'   => "click",
                        'data-kt-menu-placement' => "bottom-start",
                    ),
                    'sub'        => array(
                        'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                        'items' => array(

                            // Documentation
                            array(
                                'title' => 'Cache Script ',
                                'icon'  => "icons/duotone/Home/Library.svg",
                                'path'  => 'cache?type=script',
                            ),

                            // Changelog
                            array(
                                'title' => 'Cache Codeigniter',
                                'icon'  => "icons/duotone/Files/File.svg",
                                'path'  => 'cache?type=ci4',
                            ),
                        ),
                    ),
                ),

        ];
    

        public $documentation = [
            // Documentation menu
            // Getting Started
            array(
                'heading' => 'Getting Started'
            ),

            // Overview
            array(
                'title' => 'Overview',
                'path' => 'documentation/getting-started/overview'
            ),

            // Build
            array(
                'title' => 'Build',
                'path' => 'documentation/getting-started/build'
            ),

            array(
                'title' => 'Multi-demo',
                'path' => 'documentation/getting-started/multi-demo'
            ),

            // File Structure
            array(
                'title' => 'File Structure',
                'path' => 'documentation/getting-started/file-structure'
            ),

            // Customization
            array(
                'title' => 'Customization',
                'attributes' => array("data-kt-menu-trigger" => "click"),
                'classes' => array('item' => 'menu-accordion'),
                'sub' => array(
                    'class' => 'menu-sub-accordion',
                    'items' => array(
                        array(
                            'title' => 'SASS',
                            'path' => 'documentation/getting-started/customization/sass',
                            'bullet' => '<span class="bullet bullet-dot"></span>'
                        ),
                        array(
                            'title' => 'Javascript',
                            'path' => 'documentation/getting-started/customization/javascript',
                            'bullet' => '<span class="bullet bullet-dot"></span>'
                        )
                    )
                )
            ),

            // RTL
            array(
                'title' => 'RTL Version',
                'path' => 'documentation/getting-started/rtl'
            ),

            // Troubleshoot
            array(
                'title' => 'Troubleshoot',
                'path' => 'documentation/getting-started/troubleshoot'
            ),

            // Changelog
            array(
                'title' => 'Changelog <span class="badge badge-Changelog badge-light-danger bg-hover-danger text-hover-white fw-bold fs-9 px-2 ms-2">__v__</span>',
                'breadcrumb-title' => 'Changelog',
                'path' => 'documentation/getting-started/changelog'
            ),

            // References
            array(
                'title' => 'References',
                'path' => 'documentation/getting-started/references'
            ),

            // Separator
            array(
                'custom' => '<div class="h-30px"></div>'
            ),

            // HTML Theme
            array(
                'heading' => 'HTML Theme'
            ),

            array(
                'title' => 'Components',
                'path' => '//preview.keenthemes.com/metronic8/demo1/documentation/base/utilities.html'
            ),

            array(
                'title' => 'Documentation',
                'path' => '//preview.keenthemes.com/metronic8/demo1/documentation/getting-started.html'
            ),
        ];

}