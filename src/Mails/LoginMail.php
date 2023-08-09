<?php

namespace Src\Mails;

use Src\Models\User\UserEntity;
use stdClass;

class LoginMail extends BaseMail
{
    protected UserEntity|stdClass $user;

    public function __construct(UserEntity|stdClass $user)
    {
        $this->user = $user;
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
        return "mails.login";
    }

    public function addBodyData(): array
    {
        return ["user" => $this->user];
    }
}
