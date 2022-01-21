<?php

use CodeIgniter\I18n\Time;

if (!function_exists('assetAdmin')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdmin($path, $webpackMix = true, $type = false) 
	{
		
		if( $webpackMix == true){
			return base_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' . $path);
		}else{
			return base_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' .$type. '/' . $path);
		}
	}
}

if (!function_exists('assetCustom')) {
    /**
     * Get the asset path of RTL if this is an RTL request
     *
     * @param $path
     * @param  null  $secure
     *
     * @return string
     */
    function assetCustom($path, $webpackMix = true, $type = false) 
    { 

		if (service('Theme')->isDarkModeEnabled()) {
			
			$darkPath = str_replace('.bundle', '.'.service('Theme')->getCurrentMode().'.bundle', $path);
            if (file_exists(ROOTPATH .'public/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets' .service('Theme')->getDemo().'/'.$darkPath)) {
				return site_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' .service('Theme')->getDemo().'/'.$darkPath);
            }
		}else{
			return assetAdmin($path, $webpackMix, $type);
		}
    }
}

if (!function_exists('dateAssetsAdmin')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function dateAssetsAdmin($path, $webpackMix = true, $type = false) 
	{
		if( $webpackMix == true){
			return filemtime(env('DOCUMENT_ROOT') . '/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' . $path);
		}else{
			return filemtime(env('DOCUMENT_ROOT') . '/backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/assets/' .$type. '/' . $path);
		}
	}
}



if (!function_exists('assetAdminFavicons')) { 
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdminFavicons($path)
	{
		return base_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/favicons/' . $path);
	}
}


if (!function_exists('assetAdminLanguage')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdminLanguage($path)
	{
		return base_url('backend/themes/' . service('settings')->get('App.theme_bo', 'name') . '/language/' . $path);
	}
}


if (!function_exists('assetIfHasRTL')) {
    function assetIfHasRTL($path, $secure = null)
    {
        if (isRTL()) {
            return assetAdmin(dirname($path).'/'.basename($path, '.css').'.rtl.css');
        }

        return assetAdmin($path, $secure);
    }
}

if (!function_exists('isRTL')) {
    function isRTL()
    {
        return (bool) service('request')->input('rtl');
    }
}

if (! function_exists('app_date')) {
    /**
     * Formats a date according to the format
     * specified in the general settings page.
     *
     * It can take a string, a DateTime, or a Time instance.
     *
     * If $includeTimezone === true, will return the tz abbreviation
     * at the end of the date (i.e. CST, PST, etc)
     *
     * @param mixed $date
     *
     * @throws Exception
     */
    function app_date($date, bool $includeTime = false, bool $includeTimezone = false): string
    {
        $format = $includeTime
            ? [
            	service('settings')->get('App.dateFormat'),
                service('settings')->get('App.timeFormat'),
                $includeTimezone ? 'T' : '',
            ]
            : [
                setting('App.dateFormat'),
                $includeTimezone ? 'T' : '',
            ];

        $format = trim(implode(' ', $format));

        if (is_string($date)) {
            $date = Time::parse($date);
        }

        $date->setTimezone(service('settings')->get('App.appTimezone'));

        return $date->format($format);
	}
	
}