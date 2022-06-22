<?php

namespace TestWork\Model\Security;

use TestWork\Model\Data\DatabaseConnect;
use TestWork\Model\DBClasses\User;

class Registrator
{
    private $connect;
    public function __construct()
    {
        $this->connect = DatabaseConnect::getInstance()->getConnection();
    }

    public function registerUser(User $user) : bool
    {
        $user->hashPassword();
        
    }
}