<?php

namespace Src\Actions\Events;

use Src\Actions\Listeners\SendMailLoginListener;
use Src\Models\User\UserEntity;

class LoginEvent extends BaseEvent
{
    public function __construct(UserEntity $user)
    {
        parent::__construct();
        $this->event->user = $user;
    }

    public function listeners(): array
    {
        return [
            SendMailLoginListener::class,
        ];
    }

    public function channel()
    {
        return self::CHANNEL_DATABASE;
    }
}
