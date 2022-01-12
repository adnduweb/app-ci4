<?php namespace Adnduweb\Ci4Admin\Authentication\Resetters;

use Adnduweb\Ci4Admin\Entities\User;

/**
 * Interface ResetterInterface
 *
 * @package Adnduweb\Ci4Admin\Authentication\Resetters
 */
interface ResetterInterface
{
    /**
     * Send reset message to user
     *
     * @param User $user
     *
     * @return mixed
     */
    public function send(User $user = null): bool;

    /**
     * Returns the error string that should be displayed to the user.
     *
     * @return string
     */
    public function error(): string;

}
