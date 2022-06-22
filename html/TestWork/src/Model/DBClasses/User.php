<?php

namespace TestWork\Model\DBClasses;

use TestWork\Model\Algorythms\RandomGenerator;

class User
{
    private int $id;
    private string $username;
    private string $password;
    private string $hash;
    private int $level;
    private ?int $gameID;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function hashPassword()
    {
        $this->password = md5(md5($this->password));
    }

    public function createHashCookie()
    {
        $this->hash = md5(RandomGenerator::generateCode(10));
    }

    public function setGameID(int $gameID)
    {
        $this->gameID = $gameID;
    }
}