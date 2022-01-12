<?php namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Config\BaseConfig;
use \Adnduweb\Ci4Admin\Filters\LoginFilter;
use \Adnduweb\Ci4Admin\Filters\RoleFilter;
use \Adnduweb\Ci4Admin\Filters\PermissionFilter;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
        'login'      => LoginFilter::class,
		'role'       => RoleFilter::class,
		'permission' => PermissionFilter::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			'csrf' => ['except' => [CI_AREA_ADMIN.'/login', '/'.CI_AREA_ADMIN.'/international/translate/searchTexte', '/'.CI_AREA_ADMIN.'/medias/*']],
		],
		'after'  => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [];
}
