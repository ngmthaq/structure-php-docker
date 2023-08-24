<?php

namespace Src\Actions\Listeners;

use Src\Mails\ForgetPasswordMail;
use stdClass;

class SendForgetPasswordMailListener extends BaseListener
{
    public function handle(stdClass $event): void
    {
        $mail = new ForgetPasswordMail($event->user, $event->token);
        $mail->send();
    }
}
