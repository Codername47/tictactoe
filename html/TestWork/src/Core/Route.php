<?php

namespace TestWork\Core;

class Route
{
    static function start()
    {

        $controller_name = 'MainController';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if ( !empty($routes[1]) )
        {
            $controller_name = explode("?", $routes[1])[0];
        }


        if ( !empty($routes[2]) )
        {
            $action_name = explode("?", $routes[2])[0];
        }

        $model_name = $controller_name;



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
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
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