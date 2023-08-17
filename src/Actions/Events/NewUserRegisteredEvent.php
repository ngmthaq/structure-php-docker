<?php

namespace Src\Actions\Events;

use Src\Actions\Listeners\SendVerifyMailListener;
use Src\Models\User\UserEntity;

class NewUserRegisteredEvent extends BaseEvent
{
    public function __construct(UserEntity $user)
    {
        parent::__construct();
        $this->event->user = $user;
    }

    public function listeners(): array
    {
        return [
            SendVerifyMailListener::class,
        ];
    }

    public function channel()
    {
        return self::CHANNEL_DATABASE;
    }
}
