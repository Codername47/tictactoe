<?php

namespace TestWork\Core;

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'MainController';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[1]) )
        {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if ( !empty($routes[2]) )
        {
            $action_name = $routes[2];
        }

        $model_name = $controller_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        if(file_exists($model_path))
        {
            include "application/models/".$model_file;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = dirname(__DIR__) . "/Controller/" .$controller_file;
        if(file_exists($controller_path))
        {
            include dirname(__DIR__) . "/Controller/" .$controller_file;
        }
        else
        {
            Route::ErrorPage404();
            return;
        }
        $controller_name_with_namespace = "\TestWork\Controller\\".$controller_name;
        $controller = new $controller_name_with_namespace;
        echo $action_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
            return;
        }

    }
    static function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}