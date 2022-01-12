<?php namespace Adnduweb\Ci4Admin\Authentication\Resetters;

use Config\Email;
use Adnduweb\Ci4Admin\Entities\User;

/**
 * Class EmailResetter
 *
 * Sends a reset password email to user.
 *
 * @package Adnduweb\Ci4Admin\Authentication\Resetters
 */
class EmailResetter extends BaseResetter implements ResetterInterface
{
    /**
     * Sends a reset email
     *
     * @param User $user
     *
     * @return bool
     */
    public function send(User $user = null): bool
    {
        $email = service('email');
        $config = new Email();

        $settings = $this->getResetterSettings();

        $sent = $email->setFrom($settings->fromEmail ?? $config->fromEmail, $settings->fromName ?? $config->fromName)
              ->setTo($user->email)
              ->setSubject(lang('Auth.forgotSubject'))
              ->setMessage(view($this->config->views['emailForgot'], ['hash' => $user->reset_hash]))
              ->setMailType('html')
              ->send();

        if (! $sent)
        {
            $this->error = lang('Auth.errorEmailSent', [$user->email]);
            return false;
        }

        return true;
    }
}
