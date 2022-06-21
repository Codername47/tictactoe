<?php

namespace TestWork\Model\Data;

class DBConfig
{
    static public function getConfig()
    {
        return [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123123123',
            'database' => 'tictactoe'
        ];
    }
}