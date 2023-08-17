<?php

namespace Src\Actions\Listeners;

use Src\Mails\VerifyUserMail;
use stdClass;

class SendMailLoginListener extends BaseListener
{
    public function handle(stdClass $event): void
    {
        $mail = new VerifyUserMail($event->user);
        $mail->send();
    }
}
