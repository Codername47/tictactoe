<?php

use TestWork\Model\Data\DatabaseConnect;

require_once dirname(__DIR__).'/vendor/autoload.php';

$connection = DatabaseConnect::getInstance();
$connection->connect();
session_start();
\TestWork\Core\Route::start();