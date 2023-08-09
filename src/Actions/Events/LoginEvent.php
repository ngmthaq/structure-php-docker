<?php

namespace Src\Actions\Events;

use Src\Actions\Listeners\SendMailLoginListener;

class LoginEvent extends BaseEvent
{
    public function listeners(): array
    {
        return [
            SendMailLoginListener::class,
        ];
    }
}
