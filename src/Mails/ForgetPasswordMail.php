<?php

namespace Src\Mails;

use Src\Models\Token\TokenEntity;
use Src\Models\User\UserEntity;
use stdClass;

class ForgetPasswordMail extends BaseMail
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
            $this->user->email
        ];
    }

    public function addSubject(): string
    {
        return "Forget password";
    }

    public function addBody(): string
    {
        return "mails.forget-password-email";
    }

    public function addBodyData(): array
    {
        return ["user" => $this->user, "token" => $this->token];
    }
}
