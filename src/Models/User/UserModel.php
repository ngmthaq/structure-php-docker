<?php

namespace Src\Models\User;

use Src\Models\Base\BaseModel;

class UserModel extends BaseModel
{
    protected UserDao $user_dao;

    public function __construct()
    {
        parent::__construct();
        $this->user_dao = new UserDao();
    }

    public function getAll()
    {
        return $this->user_dao->getAll();
    }

    public function findOneByUid(string $uid)
    {
        return $this->user_dao->findOneByUid($uid);
    }

    public function findOneByEmail(string $email)
    {
        return $this->user_dao->findOneByEmail($email);
    }
}
