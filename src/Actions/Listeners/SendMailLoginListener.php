<?php

namespace Src\Actions\Listeners;

use Src\Mails\LoginMail;
use stdClass;

class SendMailLoginListener extends BaseListener
{
    public function handle(stdClass $event): void
    {
        $mail = new LoginMail($event->user);
        $mail->send();
    }
}
