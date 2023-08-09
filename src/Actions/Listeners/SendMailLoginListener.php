<?php

namespace Src\Actions\Listeners;

use Src\Mails\LoginMail;

class SendMailLoginListener extends BaseListener
{
    public function handle(): void
    {
        $mail = new LoginMail($this->data);
        $mail->send();
    }
}
