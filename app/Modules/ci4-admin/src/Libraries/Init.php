<?php
namespace Adnduweb\Ci4Admin\Libraries;

use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Libraries\Menu;

class Init
{
  	// Private Properties
     private static $menu;

     private static $horizontalMenu;
     
     public static function run()
    {
        // self::initPageLoader();
        // self::initLayout();
        // self::initHeader();
        // self::initSubheader();
        // self::initContent();
        // self::initAside();
        // self::initFooter();

        // Init layout
		self::initLayout();
		self::initHeader();
        self::initPageTitle();
       
        self::initToolbar();
		self::initContent();
		self::initAside();
		self::initFooter();

		self::initAsideMenu();
        self::initHorizontalMenu();
        
    }

    private static function initLayout()
    {
        // Theme::addHtmlAttribute('body', 'id', 'kt_body');

        // // Offcanvas directions
        // Theme::addHtmlClass('body', 'quick-panel-right');
        // Theme::addHtmlClass('body', 'demo-panel-right');
        // Theme::addHtmlClass('body', 'offcanvas-right');

        Theme::addHtmlAttribute('body', 'id', 'kt_body');

		if ( isset(Config('Theme')->layout['main']['body']['background-image'])) {
			Theme::addHtmlAttribute('body', 'style', 'background-image: url(' .  Config('Theme')->layout['main']['body']['background-image'] . ')');
		}
 
		if ( isset( Config('Theme')->layout['main']['body']['class'] ) ) {
            Theme::addHtmlClass('body', Config('Theme')->layout['main']['body']['class'] );
           
		}

		if (  isset(Config('Theme')->layout['main']['body']['attributes'] )) {
			Theme::addHtmlAttributes('body', Config('Theme')->layout['main']['body']['attributes'] );
		}

        if ( Config('Theme')->layout['loader']['display'] === true ) {
			Theme::addHtmlClass('body', 'page-loading-enabled');
			Theme::addHtmlClass('body', 'page-loading');
		}

		//Theme::addHtmlClass('body', 'modal-open');
		if (Config('Theme')->layout['main']['type'] === "default") {
			Theme::addPageJs('js/custom/widgets.js');
			Theme::addPageJs('js/custom/apps/chat/chat.js');
			Theme::addPageJs('js/custom/modals/create-app.js');
			Theme::addPageJs('js/custom/modals/upgrade-plan.js');

			if (Theme::getMode() !== 'release') {
				Theme::addPageJs('js/custom/intro.js');
			}
        }
        
    }

    // private static function initPageLoader()
    // {
    //     if (!empty(config('layout.page-loader.type'))) {
    //         Theme::addHtmlClass('body', 'page-loading-enabled');
    //         Theme::addHtmlClass('body', 'page-loading');
    //     }
    // }

    private static function initHeader()
    {

        if ( Config('Theme')->layout['header']['width'] == 'fluid') {
            Theme::addHtmlClass('header-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('header-container', 'container');
        }

		if ( Config('Theme')->layout['header']['fixed']['desktop']  === true) {
			Theme::addHtmlClass('body', 'header-fixed');
		}

        if (Config('Theme')->layout['header']['fixed']['tablet-and-mobile'] === true) {
			Theme::addHtmlClass('body', 'header-tablet-and-mobile-fixed');
        }

        if (service('settings')->get('App.mode_bo', 'dark') == 1) {
            Theme::addHtmlClass('body', 'dark-mode' );
        }
        
       
       
        // if ( Config('Theme')->layout['header']['self']['fixed']['desktop']) {
        //     Theme::addHtmlClass('body', 'header-fixed');
        //     Theme::addHtmlClass('header', 'header-fixed');
        // } else {
        //     Theme::addHtmlClass('body', 'header-static');
        // }
        
        // if (Config('Theme')->layout['header']['self']['fixed']['mobile']) {
        //     Theme::addHtmlClass('body', 'header-mobile-fixed');
        //     Theme::addHtmlClass('header-mobile', 'header-mobile-fixed');
        // }

        // // Menu
        // if ( Config('Theme')->layout['header']['menu']['self']['display']) {
        //     Theme::addHtmlClass('header_menu', 'header-menu-layout-' .  Config('Theme')->layout['header']['menu']['self']['layout']);

        //     if ( Config('Theme')->layout['header']['menu']['self']['root-arrow']) {
        //         Theme::addHtmlClass('header_menu', 'header-menu-root-arrow');
        //     }
        // }

        // if ( Config('Theme')->layout['header']['self']['width'] == 'fluid') {
        //     Theme::addHtmlClass('header-container', 'container-fluid');
        // } else {
        //     Theme::addHtmlClass('header-container', 'container');
        // }
    }

    // private static function initSubheader()
    // {
    //     if ( Config('Theme')->layout['subheader']['display']) {
    //         Theme::addHtmlClass('body', 'subheader-enabled');
    //     } else {
    //         return;
    //     }

    //     $subheader_style = Config('Theme')->layout['subheader']['style'];
    //     $subheader_fixed = Config('Theme')->layout['subheader']['fixed'];

    //     // Fixed content head
    //     if (Config('Theme')->layout['subheader']['fixed'] && Config('Theme')->layout['header']['self']['fixed']['desktop']) {
    //         Theme::addHtmlClass('body', 'subheader-fixed');
    //         $subheader_style = 'solid';
    //     } else {
    //         $subheader_fixed = false;
    //     }

    //     if ($subheader_style) {
    //         Theme::addHtmlClass('subheader', 'subheader-'.$subheader_style);
    //     }

    //     if (Config('Theme')->layout['subheader']['width'] == 'fluid') {
    //         Theme::addHtmlClass('subheader-container', 'container-fluid');
    //     } else {
    //         Theme::addHtmlClass('subheader-container', 'container');
    //     }

    //     if (Config('Theme')->layout['subheader']['clear']) {
    //         Theme::addHtmlClass('subheader', 'subheader-clear');
    //     }
    // }

    private static function initToolbar() {
        if ( Config('Theme')->layout['toolbar']['display'] === false) {
			return;
		}

		Theme::addHtmlClass('body', 'toolbar-enabled');

		if (Config('Theme')->layout['toolbar']['width'] == 'fluid') {
			Theme::addHtmlClass('toolbar-container', 'container-fluid');
		} else {
			Theme::addHtmlClass('toolbar-container', 'container');
		}

		if (Config('Theme')->layout['toolbar']['fixed']['desktop'] === true) { 
            Theme::addHtmlClass('body', 'toolbar-fixed');
		}

		if (Config('Theme')->layout['toolbar']['fixed']['tablet-and-mobile'] === true) {
			Theme::addHtmlClass('body', 'toolbar-tablet-and-mobile-fixed');
		}

		// Height setup
		$type = Config('Theme')->layout['toolbar']['layout'];
		$typeOptions = Config('Theme')->layout['toolbar']['layouts'][$type];

		if ($typeOptions) {
			if (isset($typeOptions['height'])) {
				Theme::addCssVariable('body', '--kt-toolbar-height', $typeOptions['height']);
			}

			if (isset($typeOptions['height-tablet-and-mobile'])) {
				Theme::addCssVariable('body', '--kt-toolbar-height-tablet-and-mobile', $typeOptions['height-tablet-and-mobile']);
			}
		}
    }

    private static function initPageTitle() {
		if (Config('Theme')->layout['page-title']['display'] === false) {
			return;
		}

		if (Config('Theme')->layout['page-title']['responsive'] === true) {
			$attr = array();
			$attr['data-kt-place'] = 'true';
			$attr['data-kt-place-mode'] = 'prepend';
			$attr['data-kt-place-parent'] = "{default: '#kt_content_container', '" . Config('Theme')->layout['page-title']['responsive-breakpoint'] . "': '" . Config('Theme')->layout['page-title']['responsive-target']  . "'}";

			Theme::addHtmlAttributes('page-title', $attr);
		}
	}
    

    private static function initContent()
    {
        if (Config('Theme')->layout['content']['width'] == 'fluid') { 
            Theme::addHtmlClass('content-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('content-container', 'container-xxl');
        }
    }

    private static function initAside()
    {

        // Check if aside is displayed
		if (Config('Theme')->layout['aside']['display'] != true) {
			return;
		}

		Theme::addHtmlClass('body', 'aside-enabled');
		Theme::addHtmlClass('aside', 'aside-' . Config('Theme')->layout['aside']['theme']);

		// Fixed aside
		if (Config('Theme')->layout['aside']['fixed']) {
			Theme::addHtmlClass('body', 'aside-fixed');
		}

		// Default minimized
		if (Config('Theme')->layout['aside']['minimized'] || service('settings')->get('App.theme_bo', 'asideToogle') == 0) {
			Theme::addHtmlAttribute('body', 'data-kt-aside-minimize', 'on');
		}

		// Hoverable on minimize
		if (Config('Theme')->layout['aside']['hoverable']) {
			Theme::addHtmlClass('aside', 'aside-hoverable');
        }
        
        // if (Config('Theme')->layout['aside']['self']['display'] != true) {
        //     return;
        // }

        // // Enable Aside
        // Theme::addHtmlClass('body', 'aside-enabled');

        // if (Config('Theme')->layout['aside']['self']['minimize']['hoverable']){
        //     Theme::addHtmlClass('body', 'aside-minimize-hoverable');
        // }

        // // Fixed Aside
        // if (Config('Theme')->layout['aside']['self']['fixed']){
        //     Theme::addHtmlClass('body', 'aside-fixed');
        //     Theme::addHtmlClass('aside', 'aside-fixed');
        // } else {
        //     Theme::addHtmlClass('body', 'aside-static');
        // }

        // // Check Aside
        // if (Config('Theme')->layout['aside']['self']['display'] != true) {
        //     return;
        // }

        // // Default fixed
        // if (config('layout.aside.self.minimize.default')) {
        //     Theme::addHtmlClass('body', 'aside-minimize');
        // }

        // // Menu
        // // Dropdown Submenu
        // if (Config('Theme')->layout['aside']['menu']['dropdown'] == true) {
        //     Theme::addHtmlClass('aside_menu', 'aside-menu-dropdown');
        //     Theme::addHtmlAttribute('aside_menu', 'data-menu-dropdown', '1');
        // }

        // // Scrollable Menu
        // if(Config('Theme')->layout['aside']['menu']['dropdown'] != true) {
        //     Theme::addHtmlAttribute('aside_menu', 'data-menu-scroll', "1");
        // } else {
        //     Theme::addHtmlAttribute('aside_menu', 'data-menu-scroll', "0");
        // }

        // if (Config('Theme')->layout['aside']['menu']['submenu']['dropdown']['hover-timeout']) {
        //     Theme::addHtmlAttribute('aside_menu', 'data-menu-dropdown-timeout', Config('Theme')->layout['aside']['menu']['submenu']['dropdown']['hover-timeout']);
        // }
    }

    private static function initAsideMenu() {
		if (Config('Theme')->layout['aside']['menu'] === 'documentation') {
			self::$menu = new Menu(self::getMenuModules('documentation'), service('request')->getPath(), 'documentation');
		} else {
            self::$menu = new Menu(self::getMenuModules('vertical'), service('request')->getPath(), 'vertical' );
		}

		if (isset(Config('Theme')->layout['aside']['menu-icons-display']) && Config('Theme')->layout['aside']['menu-icons-display'] === false) {
			self::$menu->displayIcons(false);
        }
        
       // print_r(self::$menu); exit;

		//self::$menu->setIconType(Config('Theme')->layout['aside']['menu-icons']);
	}

	private static function initHorizontalMenu() {
		self::$horizontalMenu = new Menu( self::getMenuModules('horizontal'), service('request')->getPath(), 'horizontal' );
		self::$horizontalMenu->setItemLinkClass('py-3');
        //self::$horizontalMenu->setIconType(Config('Theme')->layout['header']['menu-icon']);

	}

	private static function initFooter() {
		if (Config('Theme')->layout['footer']['width'] == 'fluid') {
			Theme::addHtmlClass('footer-container', 'container-fluid');
		} else {
			Theme::addHtmlClass('footer-container', 'container');
		}
    }
    
    public static function getAsideMenu() {
		return self::$menu;
    }
    
    public static function getHorizontalMenu() {
		return self::$horizontalMenu;
    }

    public static function isDocumentationMenu() {
		return ( Config('Theme')->layout['aside']['menu'] === 'documentation');
	}
    

    // public static function getBreadcrumb() {
	// 	$options = array(
	// 		'skip-active' => false
	// 	);

	// 	if ( Init::isDocumentationMenu() ) {
	// 		$path = Theme::getPagePath();
	// 		$path_parts = explode("/", $path);
	// 		$title = camelize($path_parts[1]);

	// 		$options['home'] = array(
	// 			'title' => $title,
	// 			'active' => false
	// 		);
    //     }

	// 	return Init::getAsideMenu()->getBreadcrumb($options);
    // }
    
    public static function getMenuModules(string $type){
        $namespaces = service('autoloader')->getNamespace(); 

        $items_menu = []; 
        $tabs = [];
        $construction =[];
        if(!empty($namespaces)){
            foreach ($namespaces as $k => $v){

                //print_r($k  . ' ,, ');
                if(preg_match("/Adnduweb/i", $k)) {
                    if($k != 'Adnduweb\Ci4Core' && $k != 'Adnduweb\Ci4Admin') {
                        $path = $v[0];
                        if(file_exists($path . 'Config/_Menu.php')){
                            $config = "\\{$k}\\Config\_Menu";
                            $menu = new $config();
                            //print_r($menu); 
                            if(isset($menu->{$type})){
                                 $items_menu[$menu->collection][$menu->position[$type]] = $menu->{$type}[0];
                               // $items_menu[$menu->collection] = $menu->{$type}[0];
                            }
                          
                        }
                    }  
                } 
             
            }
        }

        // print_r($items_menu);exit;
        if(!empty($items_menu)){

            if(isset($items_menu['module'])){

                 //// Modules
                $construction =  [[
                    'classes' => array('content' => 'pt-8 pb-2'),
                    'ancre'   => "modules",
                    'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
                ],
                    $items_menu
                ];
                $construction = array_merge($construction, Config('Menu')->{$type});
            }

        }  else{
            $construction =  Config('Menu')->{$type};
        }

        return array_merge(Config('Menu')->dashboard, $construction);
    
    }


}
