<?php namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Model;
use Adnduweb\Ci4Admin\Config\Auth as AuthConfig;
use Adnduweb\Ci4Admin\Authorization\FlatAuthorization;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Admin\Models\LoginModel;
use Adnduweb\Ci4Admin\Authorization\GroupModel;
use Adnduweb\Ci4Admin\Authorization\PermissionModel;
use Adnduweb\Ci4Admin\Authentication\Activators\ActivatorInterface;
use Adnduweb\Ci4Admin\Authentication\Activators\UserActivator;
use Adnduweb\Ci4Admin\Authentication\Passwords\PasswordValidator;
use Adnduweb\Ci4Admin\Authentication\Passwords\ValidatorInterface;
use Adnduweb\Ci4Admin\Authentication\Resetters\EmailResetter;
use Adnduweb\Ci4Admin\Authentication\Resetters\ResetterInterface;
use Adnduweb\Ci4Admin\Libraries\Tools;
use Adnduweb\Ci4Admin\Libraries\Theme;
use Adnduweb\Ci4Admin\Libraries\Notification;
use Adnduweb\Ci4Core\Libraries\Module;
use Config\Services as BaseService;

class Services extends BaseService
{
   public static function authentication(string $lib = 'local', Model $userModel = null, Model $loginModel = null, bool $getShared = true)
	{
		if ($getShared)
		{
			return self::getSharedInstance('authentication', $lib, $userModel, $loginModel);
		}

		$userModel  = $userModel ?? model(UserModel::class);
		$loginModel = $loginModel ?? model(LoginModel::class);

		/** @var AuthConfig $config */
		$config   = config('Auth');
		$class	  = $config->authenticationLibs[$lib];
		$instance = new $class($config);

		return $instance
			->setUserModel($userModel)
			->setLoginModel($loginModel);
	}

    public static function authorization(Model $groupModel = null, Model $permissionModel = null, Model $userModel = null, bool $getShared = true)
	{
		if ($getShared)
		{
			return self::getSharedInstance('authorization', $groupModel, $permissionModel, $userModel);
		}

		$groupModel	     = $groupModel ?? model(GroupModel::class);
		$permissionModel = $permissionModel ?? model(PermissionModel::class);
		$userModel	     = $userModel ?? model(UserModel::class);

		$instance = new FlatAuthorization($groupModel, $permissionModel);

		return $instance->setUserModel($userModel);
	}


   /**
	 * Returns an instance of the PasswordValidator.
	 *
	 * @param AuthConfig|null $config
	 * @param bool      $getShared
	 *
	 * @return ValidatorInterface
	 */
	public static function passwords(AuthConfig $config = null, bool $getShared = true): PasswordValidator
	{
		if ($getShared)
		{
			return self::getSharedInstance('passwords', $config);
		}

		return new PasswordValidator($config ?? config(AuthConfig::class));
	}

    /**
	 * Returns an instance of the Activator.
	 *
	 * @param AuthConfig|null $config
	 * @param bool      $getShared
	 *
	 * @return ActivatorInterface
	 */
	public static function activator(AuthConfig $config = null, bool $getShared = true): ActivatorInterface
	{
		if ($getShared)
		{
			return self::getSharedInstance('activator', $config);
		}

		$config = $config ?? config(AuthConfig::class);
		$class	= $config->requireActivation ?: UserActivator::class;

		return new $class($config);
    }
    
   /**
	 * Returns an instance of the Resetter.
	 *
	 * @param AuthConfig|null $config
	 * @param bool      $getShared
	 *
	 * @return ResetterInterface
	 */
	public static function resetter(AuthConfig $config = null, bool $getShared = true): ResetterInterface
	{
		if ($getShared)
		{
			return self::getSharedInstance('resetter', $config);
		}

		$config = $config ?? config(AuthConfig::class);
		$class	= $config->activeResetter ?: EmailResetter::class;

		return new $class($config);
	}

	/**
	 * Return Tools.
	 *
	 * @param bool      $getShared
	 *
	 * @return ToolsInterface
	 */
	public static function tools( bool $getShared = true): Tools
	{
		if ($getShared)
		{
			return self::getSharedInstance('tools');
		}

		return new Tools();
	}

	/**
	 * Return List Theme.
	 *
	 * @param Theme|null $config
	 * @param bool      $getShared
	 *
	 * @return ResetterInterface
	 */
	public static function theme(Theme $config = null, bool $getShared = true): Theme
	{
		if ($getShared)
		{
			return self::getSharedInstance('theme', $config);
		}

		$config = $config ?? config(Theme::class);

		return new Theme($config ?? config(Theme::class));
	}

	/**
	 * Return List Theme.
	 *
	 * @param Notifications|null $config
	 * @param bool      $getShared
	 *
	 * @return ResetterInterface
	 */
	public static function notification(Notifications $config = null, bool $getShared = true): Notification
	{
		if ($getShared)
		{
			return self::getSharedInstance('notification', $config);
		}

		$config = $config ?? config(Notifications::class);

		return new Notification($config ?? config(Notifications::class));
	}

	/**
	 * Return List Theme.
	 *
	 * @param Module|null $config
	 * @param bool      $getShared
	 *
	 * @return ResetterInterface
	 */
	public static function module(Modules $config = null, bool $getShared = true): Module
	{
		if ($getShared)
		{
			return self::getSharedInstance('module', $config);
		}

		$config = $config ?? config(Modules::class);

		return new Module($config ?? config(Modules::class));
	}
}
