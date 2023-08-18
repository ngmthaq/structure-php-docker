<?php

namespace Src\Mails;

use Src\Models\Token\TokenEntity;
use Src\Models\User\UserEntity;
use stdClass;

class VerifyUserMail extends BaseMail
{
    protected UserEntity|stdClass $user;
    protected TokenEntity|stdClass $token;

    public function __construct(UserEntity|stdClass $user, TokenEntity|stdClass $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function addAddresses(): array
    {
        return [
            "test@gmail.com"
        ];
    }

    public function addSubject(): string
    {
        return "Test mail";
    }

    public function addBody(): string
    {
        return "mails.verify-email";
    }

    public function addBodyData(): array
    {
        return ["user" => $this->user, "token" => $this->token];
    }
}
