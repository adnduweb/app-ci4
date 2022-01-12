<?php

namespace Adnduweb\Ci4Admin\Libraries;

class Theme
{

    /** @var string*/
    public static $mode;

    /** @var back */
    protected static $isBackend = false;

    /** @var string*/
    protected static $defaultTheme = 'metronic';

    /** @var string*/
    public static $name;

    /** @var string*/
    public static $demo;

    /** @var string*/
    public static $htmlAttributes;

    /** @var string*/
    public static $htmlClasses;

    /** @var string*/
    public static $cssVariables;

    /** @var string*/
    public static $page = 'index';

    /** @var string*/
    private static $currentTheme;
    
    /** @var string*/
    protected static $themeInfo;

    protected static $ignore_session = false;

    protected static $message;

    // Free version flag
    public static $freeVersion = false;

   

    protected static $message_template = "
    <script type='text/javascript'>
    $(document).ready(function(){
        toastr.{type}('{message}', '{title}');
    });</script>";

    /** @var string*/
    public static $custom = 'app.js';

    /** @var array*/
    protected static $scripts = array('external' => array(), 'inline' => array(), 'module' => array(), 'controller' => array(), 'vueJs' => array());

    /** @var array*/
    protected static $styles = array('css' => array(), 'module' => array(), 'controller' => array());

    /** @var bool*/
    private static $debug = true;

    /**
     * The URI to use for matching routed assets.
     * Defaults to uri_string()
     *
     * @var string
     */
    protected $route;

    /**
     * Whether the route has been sanitized
     * Prevents re-processing on multiple display calls
     *
     * @var bool
     */
    protected $sanitized = false;

    /**
     * Route collection used to determine the default route (if needed).
     *
     * @var CodeIgniter\Router\RouteCollectionInterface
     */
    protected $collection;


    /**
     * Sets the active theme.
     *
     * @param string $theme
     */
    public static function setTheme(string $theme)
    {
        static::$currentTheme = $theme;
    }

    /**
     * Returns the path to the specified theme folder.
     * If no theme is provided, will use the current theme.
     *
     * @param string|null $theme
     *
     * @return string
     */
    public static function path(string $theme=null): string
    {
        if (empty($theme)) {
            $theme = static::current();
        }

        // Ensure we've pulled the theme info
        if (empty(static::$themeInfo)) {
            static::$themeInfo = self::available();
        }

        foreach(static::$themeInfo as $info) {
            if ($info['name'] === $theme) {
                return $info['path'];
            }
        }

        return '';
    }

    /**
     * Returns the name of the active theme.
     *
     * @return string
     */
    public static function current()
    {
        return ! empty(static::$currentTheme)
            ? static::$currentTheme
            : static::$defaultTheme;
    }

    /**
     * Returns an array of all available themes
     * and the paths to their directories.
     *
     * @return array
     */
    public static function available(): array
    {
        $themes = [];
        helper('filesystem');


        foreach(config('Themes')->collectionsBackend as $collection) {
            $info = get_dir_file_info($collection, true);

            if (! count($info)) {
                continue;
            }

            foreach($info as $name => $row) {
                $themes[] = [
                    'name' => $name,
                    'path' => $row['relative_path']. '/' . $name .'/',
                    'hasComponents' => is_dir($row['relative_path'].$name.'/Components'),
                ];
            }
        }

        return $themes;
    }



    public static function addHtmlAttributes($scope, $attributes) {
        foreach ($attributes as $key => $value) {
            self::$htmlAttributes[$scope][$key] = $value;
        }
    }

    public static function addHtmlAttribute($scope, $name, $value)
    {
        self::$htmlAttributes[$scope][$name] = $value;
    }

    public static function addHtmlClass($scope, $class) {
        self::$htmlClasses[$scope][] = $class;
    }

    public static function delHtmlClass($scope) {
        unset(self::$htmlClasses[$scope]);
    }

    public static function addCssVariable($scope, $name, $value) {
        self::$cssVariables[$scope][$name] = $value;
    }

    public static function printHtmlAttributes($scope)
    {
        $attrs = [];

        if (isset(self::$htmlAttributes[$scope]) && !empty(self::$htmlAttributes[$scope])) {
            foreach (self::$htmlAttributes[$scope] as $name => $value) {
                $attrs[] = $name . '="' . $value . '"';
            }
            echo ' ' . implode(' ', $attrs) . ' ';
        }
        echo '';
    }

    public static function printHtmlClasses($scope, $full = true)
    {
        helper('auth');

        $controller = \Config\Services::router();
        $controllerName = explode('\\',  $controller->controllerName());
        $onload = '';


        if ($scope == 'body') {
            $setting_aside_back = (service('settings')->get('App.theme_bo', 'modeDark') == '1') ? 'aside-fixed aside-minimize' : 'aside-fixed';
            //header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled
            self::$htmlClasses[$scope][] = 'ps_back-office html controller_' . strtolower(end($controllerName)) . ' method_' . strtolower($controller->methodName()) . ' lang-' . service('request')->getLocale() . ' aside-enabled page-loading-enabled page-loading ' . $setting_aside_back;
            if(!session()->get('wait_valid_two_factor')){
                $onload = 'onload="StartTimers();" onmousemove="ResetTimers();"';
            }
        }

        // if (service('settings')->get('App.theme_bo', 'modeDark') == '1'){ 
        //     self::$htmlClasses[$scope][] .= 'aside--fixed kt-aside--minimize kt-aside-minimize-hoverable';
        // }

        //print_r(self::$htmlClasses); exit;

        if (isset(self::$htmlClasses[$scope]) && !empty(self::$htmlClasses[$scope])) {
            $classes = implode(' ', self::$htmlClasses[$scope]);
            if ($full) {
                if (logged_in()) {
                    echo 'class="' . $classes . '" ' .$onload  .' ';
                } else {
                    echo 'class="' . $classes . '"';
                }
            } else {
                if (logged_in()) {
                    echo ' ' . $classes . ' ';
                } else {
                    echo ' ' . $classes . ' ';
                }
               // echo $classes . ' ';
            }
        } else {
            echo '';
        }
    }

    public static function printCssVariables($scope, $full = true) {
        $result = array();
        if (isset(self::$cssVariables[$scope]) && !empty(self::$cssVariables[$scope])) {

            foreach (self::$cssVariables[$scope] as $name => $value) {
                if ( !empty($value) ) {
                    $result[] = $name . ':' . $value;
                }
            }

            $result = implode(';', $result);

            if ( $full === true ) {
                return ' style="' . $result . '" ';
            } else {
                return ' ' . $result . ' ';
            }
        }
    }

    public static function getPagePath() {
        return self::$page;
    }

    public static function getAssetsPath() {

        return service('settings')->get('App.theme_bo', 'name') . '/assets/';
    }

    public static function getMediaPath() {
        return self::getAssetsPath() . 'media/';
    }

    public static function getBaseUrlPath() {
        return site_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/');
    }

    public static function getAssetsUrlPath() {
        return self::getBaseUrlPath() . 'assets/';
    }

    public static function getMediaUrlPath() {
        return self::getAssetsUrlPath() . 'media/';
    }

    /**
     * Prints Google Fonts
     */
    public static function includeFonts()
    {
        if (config('Theme')->layout['assets']['fonts']['google']) {
            $fonts = config('Theme')->layout['assets']['fonts']['google'];
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . implode('|', $fonts) . '">';
        }
        echo '';
    }

    public static function rtlCssFilename($path) {
        if (isset($_REQUEST['rtl']) && $_REQUEST['rtl'] == 1) {
            if (strpos($path, 'fullcalendar') !== false) {
            } else {
                $path = str_replace('.css', '.rtl.css', $path);
            }

            if (isset($_REQUEST['mode']) && $_REQUEST['mode'] && !in_array($_REQUEST['mode'], ['default', 'rtl'])) {
                if (self::isDarkModeEnabled() && (strpos($path, 'plugins.bundle') !== false || strpos($path, 'style.bundle') !== false)) {
                    // import dark mode css
                    $path = str_replace('.bundle', '.'.$_REQUEST['mode'].'.bundle', $path);
                }
            }

        } elseif (isset($_REQUEST['mode']) && $_REQUEST['mode'] && !in_array($_REQUEST['mode'], ['default', 'rtl'])) {
            if (self::isDarkModeEnabled() && (strpos($path, 'plugins.bundle.css') !== false || strpos($path, 'style.bundle.css') !== false)) {
                // import dark mode css
                $path = str_replace('.bundle', '.'.$_REQUEST['mode'].'.bundle', $path);
            }
        }

        return $path;
    }

    public static function isRTL() {
        if (isset($_REQUEST['rtl']) && $_REQUEST['rtl'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function strposa($haystack, $needle, $offset = 0) {
        if (!is_array($needle)) {
            $needle = array($needle);
        }
        foreach ($needle as $query) {
            if (strpos($haystack, $query, $offset) !== false) {
                return true;
            } // stop on first true result
        }

        return false;
    }

    /**
     * Check if current theme has dark mode
     *
     * @return bool
     */
    public static function isDarkModeEnabled() {
        return (bool) service('settings')->get('App.theme_bo', 'modeDark');
    }

    /**
     * Get current mode
     *
     * @return mixed|string
     */
    public static function getCurrentMode() {

        if(service('settings')->get('App.theme_bo', 'modeDark') == 1 || env('modeTheme', 1)){
            return 'dark';
        }

        return 'default';
    }

    /**
     * Check dark mode
     *
     * @return mixed|string
     */
    public static function isDarkMode() {
        //return self::getCurrentMode() === 'dark';
        return service('settings')->get('App.theme_bo', 'modeDark') == '1';
    }

    public static function getPageUrl($path, $demo = '', $mode = null) {
        // Disable pro page URL's for the free version
        if (self::isFreeVersion() === true && self::isProPage($path) === true) {
            return "#";
        }

        $baseUrl = self::getBaseUrlPath();

        $params = '';
        if (isset($_REQUEST['type']) && $_REQUEST['type'] === 'html') {
            // param keep in url
            if (isset($_REQUEST['rtl']) && $_REQUEST['rtl']) {
                $params = 'rtl/';
            }

            if ($mode !== null) {
                if ($mode) {
                    $params = $mode.'/';
                }
            } else {
                if (isset($_REQUEST['mode']) && $_REQUEST['mode']) {
                    $params = $_REQUEST['mode'].'/';
                }
            }

            if (!empty($demo)) {
                if (self::getViewMode() === 'release') {
                    // force add link to other demo in release
                    $baseUrl .= '../../'.$demo.'/dist/';
                } else {
                    // for preview
                    $baseUrl .= '../'.$demo.'/'.$params;
                }
            } else {
                $d = '';
                if (!empty(self::getDemo())) {
                    $d = '../'.self::getDemo().'/';
                }
                if (self::getViewMode() === 'release') {
                    // force add link to other demo in release
                    $baseUrl .= '../'.$d.'dist/';
                } else {
                    // for preview
                    $baseUrl .= $d.$params;
                }
            }

            $url = $baseUrl.$path.'.html';

            // skip layout builder page for generated html
            if (strpos($path, 'builder') !== false && self::getViewMode() === 'release') {

                if (!empty(self::getDemo())) {
                    $path = self::getDemo().'/'.$path;
                }

                $url = self::getOption('product', 'preview').'/'.$path.'.html';
            }
        } else {
            if (isset($_REQUEST['rtl']) && $_REQUEST['rtl']) {
                $params = '&rtl=1';
            }

            if ($mode !== null) {
                if ($mode) {
                    $params = '&mode='.$mode;
                }
            } else {
                if (isset($_REQUEST['mode']) && $_REQUEST['mode']) {
                    $params = '&mode='.$_REQUEST['mode'];
                }
            }

            if (!empty($demo)) {
                // force add link to other demo
                $baseUrl .= '../../'.$demo.'/dist/';
            }

            $url = $baseUrl.'?page='.$path.$params;
        }

        return $url;
    }

    public static function isCurrentPage($path) {
        return self::$page === $path;
    }

    public static function getSvgIcon($path, $class = '', $svgClass = '') {
        $path = str_replace('\\', '/', $path);
        $full_path = $path;
        if ( ! file_exists($path)) {
            $full_path = self::getMediaPath().$path;

            if ( ! is_string($full_path)) {
                return '';
            }

            if ( ! file_exists($full_path)) {
                return "<!--SVG file not found: $path-->\n";
            }
        }

        $svg_content = file_get_contents($full_path);

        $dom = new \DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if ( ! empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if ( ! empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/'.$asd[1];
        }

        $output  = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="'.implode(' ', $cls).'">'.$string.'</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }

    /**
     * Walk recursive array with callback
     * @param array    $array
     * @param callable $callback
     * @return array
     */
    public static function arrayWalkCallback(array &$array, callable $callback)
    {
        foreach ($array as $k => &$v) {
            if (is_array($v)) {
                $callback($k, $v, $array);
                self::arrayWalkCallback($v, $callback);
            }
        }

        return $array;
    }

    /**
     * Convert css file path to RTL file
     */
    public static function rtlCssPath($css_path)
    {
        $css_path = substr_replace($css_path, '.rtl.css', -4);

        return $css_path;
    }

    /**
     * Initialize theme CSS files
     */
    public static function initThemes()
    {
        $themes = [];

        $themes[] = 'css/themes/layout/header/base/' . config('Theme')->layout['header']['self']['theme'] . '.css';
        $themes[] = 'css/themes/layout/header/menu/' . config('Theme')->layout['header']['menu']['desktop']['submenu']['theme'] . '.css';
        $themes[] = 'css/themes/layout/aside/' . config('Theme')->layout['aside']['self']['theme'] . '.css';

        if (config('Theme')->layout['aside']['self']['display']) {
            $themes[] = 'css/themes/layout/brand/' . config('Theme')->layout['brand']['self']['theme'] . '.css';
        } else {
            $themes[] = 'css/themes/layout/brand/' . config('Theme')->layout['brand']['self']['theme'] . '.css';
        }

        return $themes;
    }

    /**
     * Get SVG content
     * @param string $filepath
     * @param string $class
     *
     * @return string|string[]|null
     */
    public static function getSVG($filepath, $class = '', $nav = false, $javascript = false)
    {
        $filepath = ROOTPATH . 'public/backend/themes/' .self::getMediaPath() . $filepath; 

        
        $path = str_replace('\\', '/', $filepath);
        $full_path = $path;

        if ( ! file_exists($path)) {
            $full_path = self::getMediaPath().$path;

            if ( ! is_string($full_path)) {
                return '';
            }

            if ( ! file_exists($full_path)) {
                return "<!--SVG file not found: $path-->\n";
            }
        }
        //var_dump($full_path);
        $svg_content = @file_get_contents($full_path);
        if(!$svg_content){
            return '';
        }

        $dom = new \DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if ( ! empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if ( ! empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/'.$asd[1];
        }

        $output  = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="'.implode(' ', $cls).'">'.$string.'</span>';
        $output .= "\n<!--end::Svg Icon-->";

        if($javascript == true){
            $search = array(
                '/(\n|^)(\x20+|\t)/',
                '/(\n|^)\/\/(.*?)(\n|$)/',
                '/\n/',
                '/\<\!--.*?-->/',
                '/(\x20+|\t)/', # Delete multispace (Without \n)
                '/\>\s+\</', # strip whitespaces between tags
                '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
                '/=\s+(\"|\')/'); # strip whitespaces between = "'
            
               $replace = array(
                "\n",
                "\n",
                " ",
                "",
                " ",
                "><",
                "$1>",
                "=$1");
                $html = preg_replace($search,$replace,$output);
                return $html;
        }

        return $output;
    }

    /**
     * Check if $path provided is SVG
     */
    public static function isSVG($path)
    {
        if (is_string($path)) {
            return substr(strrchr($path, '.'), 1) === 'svg';
        }

        return false;
    }

    public static function getVersion() {
        return Config("Theme")->version;
    }

    /**
     * --------------------------------------------------------------------------------------------------------------
     * Get message Toast on application
     * --------------------------------------------------------------------------------------------------------------
     */

    public static function set_message($type = 'info', $message = '', $title = 'info')
    {
        if (empty($message)) {
            return;
        }
        $session = \Config\Services::session();

        if (!self::$ignore_session && isset($session)) {
            //echo serialize($message); exit;
            $message = serialize($message);
            $session->setFlashdata('message', "{$type}::{$message}::{$title}");
        }

        self::$message = array(
            'type' => $type,
            'message' => $message,
            'title' => $title
        );
    }

    public static function message($type = 'information', $message = '', $title = 'standard')
    {
        helper('html');
        // Does session data exist?
        $session = \Config\Services::session();

        if (empty($message) && !self::$ignore_session) {
            $message = $session->getFlashdata('message');
            if (!empty($message)) {
                // Split out the message parts
                $temp_message = explode('::', $message);
                if (count($temp_message) > 3) {
                    $type = $temp_message[0];
                    $message = $temp_message[1];
                    $title = $temp_message[2];
                } else {
                    $type = $temp_message[0];
                    $message = $temp_message[1];
                    $title = $temp_message[2];
                }

                unset($temp_message);
            }
        }



        // If message is empty, check the $message property.
        if (empty($message)) {
            if (empty(self::$message['message'])) {
                return '';
            }
            $message = unserialize(self::$message['message']);
            $type = self::$message['type'];
            $title = self::$message['title'];
        }
        $message = unserialize($message);
        $templateVarMessage = '';
        if (is_array($message) && !empty($message)) {
            $templateVarMessage .= '<ul>';
            foreach ($message as $k => $v) {
                $templateVarMessage .= '<li>' . addslashes($v) . '</li>';
            }
            $templateVarMessage .= '</ul>';
        } else {
            $templateVarMessage = addslashes($message);
        }

        $template = str_replace(
            array('{title}', '{type}', '{message}', '{title}'),
            array($title, $type, minify_html($templateVarMessage), $title),
            self::$message_template
        );

        return $template;
    }

    /**
     * --------------------------------------------------------------------------------------------------------------
     * Assets management js*, css*, media*
     * --------------------------------------------------------------------------------------------------------------
     */


    public static function css($style = null, $media = 'screen', $bypassInheritance = false, $bypassModule = false)
    {
        $request = \Config\Services::request();
        $nameUri = (implode('_', $request->uri->getSegments()));

        /** Cache */
        if (env('assets.minifyCSS') == true) {
            if (file_exists(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min/app_'.md5($nameUri).'.css')) {
                return self::buildStyleLink(['href' => '/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min/app_'.md5($nameUri).'.css','media' => 'screen']);
            }
        }
        if ($media == '1') {
            $media = 'screen';
        }
        $styles = array();
        if (empty($style)) {
            // $styles = self::$styles['css'];
            $styles = array_merge(self::$styles['css'], self::$styles['module'], self::$styles['controller']);
        } elseif (is_array($style)) {
            $styles = array_merge($style, self::$styles['css']);
        } else {
            $styles[] = array(
                'file' => $style,
                'media' => $media
            );
        }
        
        if (!file_exists(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/custom.css')) {
            $file = fopen(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/custom.css', "w");
            echo fwrite($file, "/********** custom css *********/");
            fclose($file);
            $custom[] = array(
                'file' => '/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/custom.css',
                'media' => $media
            );
            $styles = array_merge($styles, $custom);
        } else {
            $custom[] = array(
                'file' => '/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/custom.css',
                'media' => $media
            );
            $styles = array_merge($styles, $custom);
        }
        $return = '';
       
        if (env('assets.minifyCSS') == true) {
            if (!is_dir(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min')) {
                try {
                    mkdir(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min', 0755);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
            $minifier = new Minify\CSS();
            if (is_array($styles)) {
                foreach ($styles as $style) {
                    $minifier->add(ROOTPATH.'public/'.$style['file']);
                }
            }
            $minifier->minify(ROOTPATH.'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min/app_'.md5($nameUri).'.css');
            $return .= self::buildStyleLink(['href' => '/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/assets/css/min/app_'.md5($nameUri).'.css','media' => 'screen']);
        } else {
            foreach ($styles as $styleToAdd) {
                if (is_array($styleToAdd)) {
                    $attr          = array(
                        'href' => $styleToAdd['file']
                    );
                    $attr['media'] = empty($styleToAdd['media']) ? $media : $styleToAdd['media'];
                } elseif (is_string($styleToAdd)) {
                    $attr = array(
                        'href' => $styleToAdd,
                        'media' => $media
                    );
                } else {
                    continue;
                }
                if (substr($attr['href'], -4) != '.css') {
                    $attr['href'] .= '.css';
                }
                $return .= self::buildStyleLink($attr);
            }
            return $return;
        }
    }

    public static function add_css($style = null, $media = 'screen', $prepend = false)
    {
        if (empty($style)) {
            return;
        }
        if ($media == '1') {
            $media = 'screen';
        }
        if (is_string($style)) {
            $style = array(
                $style
            );
        }
        $stylesToAdd = array();
        if (is_array($style)) {
            foreach ($style as $file) {
                $stylesToAdd[] = array(
                    'file' => '/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' . $file,
                    'media' => $media
                );
            }
        }

        if ($prepend) {
            self::$styles['css'] = array_merge($stylesToAdd, self::$styles['css']);
        } else {
            self::$styles['css'] = array_merge(self::$styles['css'], $stylesToAdd);
        }
    }

    public static function add_js($script = null, $type = 'external', $prepend = false, $vueJs = false)
    {
        $themeCurrent = service('settings')->get('App.theme_bo', 'name');

        if (is_array($script) && count($script)) {
           
            foreach ($script as &$scrip) {
                //Dectect url
                $retour = strstr($scrip, '://', true);
                if (!$retour) {
                    if (env('CI_WEBPACK_MIX') == 'true') {
                        $scrip = '/backend/themes/' . $themeCurrent . $scrip;
                    } else {
                        $scrip = '/backend/themes/' . $themeCurrent . '/assets/' . $scrip;
                    }
                }
            }
        } else {
            $retour = strstr($script, '://', true);
            //print_r($script); exit;
            if (!$retour) {
                if (env('CI_WEBPACK_MIX') == 'true') {
                   // $script = str_replace("/resources/" . $themeCurrent, '/' . ENVIRONMENT, $script);
                    $script = '/backend/themes/' . $themeCurrent . $script;
                } else {
                    $script = '/backend/themes/' . $themeCurrent . '/assets/' . $script;
                }
            }
        }


        if (empty($script)) {
            return;
        }
        if (is_string($script)) {
            $script = array(
                $script
            );
        }
        $scriptsToAdd = array();
        if (is_array($script) && count($script)) {
            foreach ($script as $s) {
                if (!in_array($s, self::$scripts[$type])) {
                    $scriptsToAdd[] = $s;
                }
            }
        }
        if ($prepend) {
            self::$scripts[$type] = array_merge($scriptsToAdd, self::$scripts[$type]);
        } else {
            self::$scripts[$type] = array_merge(self::$scripts[$type], $scriptsToAdd);
        }
    }

    public static function add_module_js($module = '', $file = '')
    {
        if (empty($file)) {
            return;
        }
        if (is_string($file)) {
            $file = array(
                $file
            );
        }
        if (is_array($file) && count($file)) {
            foreach ($file as $s) {
                self::$scripts['module'][] = array(
                    'module' => $module,
                    'file' => $s
                );
            }
        }
    }

    public static function js($script = null, $type = 'external')
    {
        if (!empty($script)) {
            if (is_string($script) && $type == 'external') {
                return self::external_js($script);
            }
            self::add_js($script, $type);
        }
 

        $output = '<!-- Local JS files -->' . PHP_EOL;
        helper('auth');
        if (logged_in() == true) {
            $url = '\backend\themes\/'. service('settings')->get('App.theme_bo', 'name') .'\/' . ENVIRONMENT . '\js\app.js';
            if (is_file(env('DOCUMENT_ROOT') . $url)) {
                $output .=  self::buildScriptElement($url, 'text/javascript') . "\n";
            } else {
            }
        }

        $output .= self::external_js();
        $output .= self::module_js();
        $output .= self::vue_js();
        $output .= self::inline_js();
        return $output;
    }

    public static function external_js($extJs = null, $list = false, $addExtension = true, $bypassGlobals = false, $bypassInheritance = false)
    {

        $return             = '';
        $scripts            = array();
        $renderSingleScript = false;
        if (empty($extJs)) {
            $scripts = self::$scripts['external'];
        } elseif (is_string($extJs)) {
            $scripts[]          = $extJs;
            $renderSingleScript = true;
        } elseif (is_array($extJs)) {
            $scripts = $extJs;
        }


        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $return .= self::buildScriptElement($script, 'text/javascript') . "\n";
            }
        }

        return trim($return, ', ');
    }

    public static function vue_js($extJs = null, $list = false, $addExtension = true, $bypassGlobals = false, $bypassInheritance = false)
    {

        $return             = '';
        $scripts            = array();
        $renderSingleScript = false;
        if (empty($extJs)) {
            $scripts = self::$scripts['vueJs'];
        } elseif (is_string($extJs)) {
            $scripts[]          = $extJs;
            $renderSingleScript = true;
        } elseif (is_array($extJs)) {
            $scripts = $extJs;
        }



        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $return .= self::buildScriptElement($script, 'module') . "\n";
            }
        }

        return trim($return, ', ');
    }

    public static function module_js($list = false, $cached = false)
    {
        if (empty(self::$scripts['module']) || !is_array(self::$scripts['module'])) {
            return '';
        }
        $scripts = self::find_files(self::$scripts['module'], 'js');
        $src     = self::combine_js($scripts, 'module') . ($cached ? '' : '?_dt=' . time());
        if ($list) {
            return '"' . $src . '"';
        }
        return self::buildScriptElement($src, 'text/javascript') . "\n";
    }

    public static function inline_js()
    {
        if (empty(self::$scripts['inline'])) {
            return;
        }
        $content = self::$ci->config->item('assets.js_opener') . "\n";
        $content .= implode("\n", self::$scripts['inline']);
        $content .= "\n" . self::$ci->config->item('assets.js_closer');
        return self::buildScriptElement('', 'text/javascript', $content);
    }

    protected static function buildScriptElement($src = '', $type = '', $content = '')
    {

        if (!file_exists(env('DOCUMENT_ROOT') . $src) && !strstr($src, '://', true)) {
            return '<div class="red-not-script" style="position: absolute; z-index: 99999;background: #c32d00; width: 100%; color: #fff;  padding: 10px;"> le lien n\'existe pas : ' . $src . '</div>';
        }
        if (empty($src) && empty($content)) {
            return '';
        }
        $return = '<script';
        if (!empty($type)) {
            $return .= ' type="' . htmlspecialchars($type, ENT_QUOTES) . '"';
        }
        if (!empty($src) && !strstr($src, '://', true)) {
            $return .= ' src="' . htmlspecialchars(base_url($src), ENT_QUOTES) . '?v=' . filemtime(env('DOCUMENT_ROOT') . $src) . '"';
        }
        if (!empty($src) && strstr($src, '://', true)) {
            $return .= ' src="' . htmlspecialchars($src, ENT_QUOTES) . '"';
        }
        $return .= '>';
        if (!empty($content)) {
            $return .= "\n{$content}\n";
        }
        return "{$return}</script>";
    }
    protected static function buildStyleLink(array $style)
    {
        $default    = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => '',
            'media' => 'all'
        );
        $styleToAdd = array_merge($default, $style);
        $final      = '<link';
        foreach ($default as $key => $value) {
            $final .= " {$key}='" . htmlspecialchars($styleToAdd[$key], ENT_QUOTES) . "'";
        }
        $style =  "{$final} />";
        echo $style  . "\n";
    }

    public function assets_url($path = null) 
    {
        return $path;
    }

    // Cleans up the route and expands implicit segments
    protected function sanitizeRoute()
    {
        if ($this->sanitized) {
            return;
        }

        // If no route was specified then load the current URI string
        if (is_null($this->route)) {
            $this->route = uri_string();
        }

        // If no collection was specified then load the default shared
        if (is_null($this->collection)) {
            $this->collection = Services::routes();
        }

        // Sanitize characters
        $this->route = filter_var($this->route, FILTER_SANITIZE_URL);

        // Clean up slashes
        $this->route = trim($this->route, '/');

        // Verify for {locale}
        if (Config::get('App')->negotiateLocale) {
            $route = explode('/', $this->route);
            if (count($route) && $route[0] == Services::request()->getLocale()) {
                unset($route[0]);
            }
            $this->route = implode('/', $route);
        }

        // If the route is empty then assume the default controller

        if (empty($this->route)) {
            $this->route = strtolower($this->collection->getDefaultController());
        }

        // Always check the default method in case the route is implicit
        $defaultMethod = $this->collection->getDefaultMethod();
        if (!preg_match('/' . $defaultMethod . '$/', $this->route)) {
            $this->route .= '/' . $defaultMethod;
        }

        $this->sanitized = true;
    }


    public static function isDocumentationMenu() {
		return (Config('Theme')->layout['aside']['menu'] === 'documentation');
	}

     /**
     * Sets the theme's mode.
     *
     * @param string $value the theme's mode(preview, release).
    */
    public static function setMode($value) {
        // force preview mode on server
        if (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], 'keenthemes.com') !== false) {
            self::$mode = 'preview';
        } elseif (isset($_REQUEST['type']) && $_REQUEST['type'] === 'html') {
            self::$mode = 'release';
        } else {
            self::$mode = $value;
        }
    }

    public static function getMode() {
        return self::$mode;
    }

    public static function getName() {
        return self::$name;
    }

    public static function addPageJs($path) {
        Config('Theme')->page["assets"]['custom']['js'][] = $path;
    }

    public static function isFreeVersion() {
        if (isset($_REQUEST['free'])) {
            return filter_var($_REQUEST['free'], FILTER_VALIDATE_BOOLEAN);
        }

        return self::$freeVersion;
    }

    public static function setFreeVersion($flag) {
        return self::$freeVersion = $flag;
    }

    public static function getDemo() {
        return self::$demo;
    }

    public static function hasWebpack() {
        return !(isset($_REQUEST['webpack']) && !filter_var($_REQUEST['webpack'], FILTER_VALIDATE_BOOLEAN));
    }

    public static function isProPage($path) {
        $pageConfig = self::getPageOptionsByPath($path);

        if ($pageConfig && isset($pageConfig['pro']) && $pageConfig['pro'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public static function getPageOptionsByPath($path) {
        if (service('tools')::hasArrayValue(self::$config['pages'], $path)) {
            return service('tools')::getArrayValue(self::$config['pages'], $path);
        } else {
            return false;
        }
    }
}
