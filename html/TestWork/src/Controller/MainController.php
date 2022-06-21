<?php

namespace TestWork\Controller;

use TestWork\Core\Controller;

class MainController implements Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        require_once dirname(__DIR__)."/View/index.php";
    }
}