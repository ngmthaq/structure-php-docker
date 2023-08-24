<?php

namespace Src\Actions\Events;

use Src\Actions\Listeners\SendForgetPasswordMailListener;
use Src\Models\Token\TokenEntity;
use Src\Models\User\UserEntity;

class SendForgetPasswordMailEvent extends BaseEvent
{
    public function __construct(UserEntity $user, TokenEntity $token)
    {
        parent::__construct();
        $this->event->user = $user;
        $this->event->token = $token;
    }

    public function listeners(): array
    {
        return [
            SendForgetPasswordMailListener::class
        ];
    }

    public function channel()
    {
        return self::CHANNEL_DATABASE;
    }
}
