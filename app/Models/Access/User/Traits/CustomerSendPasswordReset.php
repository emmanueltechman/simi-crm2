<?php

namespace App\Models\Access\User\Traits;

use App\Notifications\Frontend\Auth\CustomerNeedsPasswordReset;

/**
 * Class UserSendPasswordReset.
 */
trait CustomerSendPasswordReset
{
    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerNeedsPasswordReset($token));
    }
}
