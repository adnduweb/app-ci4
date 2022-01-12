<?php namespace Adnduweb\Ci4Admin\Authentication\Activators;

use CodeIgniter\Entity;
use Adnduweb\Ci4Admin\Entities\User;

/**
 * Interface ActivatorInterface
 *
 * @package Adnduweb\Ci4Admin\Authentication\Activators
 */
interface ActivatorInterface
{
    /**
     * Send activation message to user
     *
     * @param User $user
     *
     * @return bool
     */
    public function send(User $user = null): bool;

    /**
     * Returns the error string that should be displayed to the user.
     *
     * @return string
     */
    public function error(): string;

}
