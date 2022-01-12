<?php namespace Adnduweb\Ci4Admin\Authentication\Resetters;


use Adnduweb\Ci4Admin\Entities\User;

class UserResetter
{
	/**
	 * Sends reset message to the user via specified class
	 * in `$activeResetter` setting in Config\Auth.php.
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function send(User $user = null): bool
	{
		if ($this->config->activeResetter === null)
		{
			return true;
		}

		$className = $this->config->activeResetter;

		$class = new $className();
		$class->setConfig($this->config);

		if ($class->send($user) === false)
		{
			log_message('error', lang('Auth.errorResetting', [$user->username]));
			$this->error = $class->error();

			return false;
		}

		return true;
	}
}
