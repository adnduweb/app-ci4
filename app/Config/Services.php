<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use Adnduweb\Ci4Core\View\View;
use Config\Services as AppServices;
use Config\View as ViewConfig;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
/**
	 * The Renderer class is the class that actually displays a file to the user.
	 * The default View class within CodeIgniter is intentionally simple, but this
	 * service could easily be replaced by a template engine if the user needed to.
	 *
	 * @param string|null     $viewPath
	 * @param ViewConfig|null $config
	 * @param boolean         $getShared
	 *
	 * @return View
	 */
	public static function renderer(string $viewPath = null, ViewConfig $config = null, bool $getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('renderer', $viewPath, $config);
		}

		$viewPath = $viewPath ?: config('Paths')->viewDirectory;
		$config   = $config ?? config('View');

		return new View($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
	}

	// public static function eloquent($getShared = true)
	// {
	// 	if ($getShared)
	// 	{
	// 		return static::getSharedInstance('eloquent');
	// 	}
	// 	return new \Config\Eloquent();
	// }
}
