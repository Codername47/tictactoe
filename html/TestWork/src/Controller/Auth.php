<?php

namespace TestWork\Controller;

use TestWork\Core\Controller;
use TestWork\Model\Data\DatabaseConnect;
use TestWork\Model\DBClasses\User;
use TestWork\Model\Security\Registrator;

class Auth implements Controller
{
    public function index()
    {
        header('Location: /auth/authorization');
    }
    public function authorization()
    {
        require_once dirname(__DIR__)."/View/Authorization/authorization.php";
    }

    public function authorizate()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET")
            header('Location: ../auth/authorization');
    }

    public function register()
    {
        require_once dirname(__DIR__)."/View/Register/register.php";
    }

    public function reg()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET")
            header('Location: ../auth/register');
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $_SESSION['err'] = "Логин может состоять только из букв английского алфавита и цифр";
            header('Location: ../auth/register');
            return;
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 16)
        {
            $_SESSION['err'] = "Логин должен быть не меньше 3-х символов и не больше 16";
            header('Location: ../auth/register');
            return;
        }

        if(strlen($_POST['password']) < 6 or strlen($_POST['password']) > 32)
        {
            $_SESSION['err'] = "Пароль должен быть не меньше 6-х символов и не больше 32";
            header('Location: ../auth/register');
            return;
        }
        if($_POST['password'] != $_POST['repeatPassword'])
        {
            $_SESSION['err'] = "Пароли должны совпадать";
            header('Location: ../auth/register');
            return;
        }
        $connection = DatabaseConnect::getInstance()->getConnection();
        $str = "SELECT * FROM `user` WHERE `username` = ?";
        $query = $connection->prepare($str);
        $query->execute($_POST['user']);
        if ($query->fetch())
        {
            $_SESSION['err'] = "Существует пользователь с таким именем";
            header('Location: ../auth/register');
            return;
        }
        $user = new User(trim($_POST['login']), trim($_POST['password']));
        $registrator = new Registrator();
        $registrator->registerUser($user);

    }
}