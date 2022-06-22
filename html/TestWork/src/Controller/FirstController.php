<?php

namespace TestWork\Controller;

use TestWork\Core\Controller;

class FirstController implements Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        require_once dirname(__DIR__) . "/View/Game/gameView.php";
    }
}