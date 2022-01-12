<?php

use Config\Services;

if (! function_exists('logged_in'))
{
	/**
	 * Checks to see if the user is logged in.
	 *
	 * @return bool
	 */
	function logged_in()
	{
		return service('authentication')->check();
	}
}

if (! function_exists('user'))
{
	/**
	 * Returns the User instance for the current logged in user.
	 *
	 * @return \Adnduweb\Ci4Admin\Entities\User|null
	 */
	function user()
	{
		$authenticate = service('authentication');
		$authenticate->check();
		return $authenticate->user();
	}
}

if (!function_exists('company')) {
	/**
	 * Returns the User instance for the current logged in user.
	 *
	 * @return \Adnduweb\Ci4Admin\Entities\Company|null
	 */
	function company()
	{
		$authenticate = Services::authentication();
		$authenticate->check();
		return $authenticate->company();
	}
}


if (! function_exists('user_id'))
{
	/**
	 * Returns the User ID for the current logged in user.
	 *
	 * @return int|null
	 */
	function user_id()
	{
		$authenticate = service('authentication');
		$authenticate->check();
		return $authenticate->id();
	}
}

if (! function_exists('in_groups'))
{
	/**
	 * Ensures that the current user is in at least one of the passed in
	 * groups. The groups can be passed in as either ID's or group names.
	 * You can pass either a single item or an array of items.
	 *
	 * Example:
	 *  in_groups([1, 2, 3]);
	 *  in_groups(14);
	 *  in_groups('admins');
	 *  in_groups( ['admins', 'moderators'] );
	 *
	 * @param mixed  $groups
	 *
	 * @return bool
	 */
	function in_groups($groups): bool
	{
		$authenticate = service('authentication');
        $authorize    = service('authorization');

        if ($authenticate->check())
        {
            return $authorize->inGroup($groups, $authenticate->id());
        }

        return false;
	}
}


if (!function_exists('inGroups')) {
	/**
	 * Ensures that the current user is in at least one of the passed in
	 * groups. The groups can be passed in as either ID's or group names.
	 * You can pass either a single item or an array of items.
	 *
	 * Example:
	 *  in_groups([1, 2, 3]);
	 *  in_groups(14);
	 *  in_groups('admins');
	 *  in_groups( ['admins', 'moderators'] );
	 *
	 * @param mixed  $groups
	 *
	 * @return bool
	 */
	function inGroups($groups, $id): bool
	{
		$authenticate = service('authentication');
        $authorize    = service('authorization');

		if ($authenticate->check()) {
			return $authorize->inGroup($groups, $id);
		}

		return false;
	}
}


if (! function_exists('has_permission'))
{
	/**
	 * Ensures that the current user has the passed in permission.
	 * The permission can be passed in either as an ID or name.
	 *
	 * @param int|string $permission
	 *
	 * @return bool
	 */
	function has_permission($permission): bool
	{
		$authenticate = service('authentication');
        $authorize    = service('authorization');

        if ($authenticate->check())
        {
			// SI je suis un Super User j'ai acès à tous
			if (inGroups(1, $authenticate->id())) {
				return true;
			} else {
				return $authorize->hasPermission($permission, $authenticate->id()) ?? false;
			}
        }

        return false;
	}
}


if (!function_exists('isSuperUser')) {
	/**
	 * @return bool
	 */
	function isSuperUser($id = null): bool
	{
		$authorize    = service('authorization');
		$id = (is_null($id)) ? user()->id : $id ; 

		if ($authorize->inGroup(1, $id)) {
			return true;
		}

		return false;
	}
}

if (!function_exists('isAdmin')) {
	/**
	 * @return bool
	 */
	function isAdmin($id = null): bool
	{
		$authorize    = service('authorization');
		$id = (is_null($id)) ? user()->id : $id ; 

		if ($authorize->inGroup(2, $id)) {
			return true;
		}

		return false;
	}
}