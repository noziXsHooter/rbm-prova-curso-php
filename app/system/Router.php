<?php

namespace scMVC\System;

use scMVC\Controllers\Main;
use Exception;

class Router{
    public static function dispatch()
    {
        // rotas principais
        $httpverb = $_SERVER['REQUEST_METHOD'];
        $controller = 'main';
        $method = 'index';

        //CHECAR OS PARAMETROS DA URL
        if(isset($_GET['ct'])){
            $controller = $_GET['ct'];
        }
        if(isset($_GET['mt'])){
            $method = $_GET['mt'];
        }

        $parameters = $_GET;

        if(key_exists("ct", $parameters)){
            unset($parameters['ct']);
        }

        if(key_exists("mt", $parameters)){
            unset($parameters['mt']);
        }
/*         printData($_GET); */
        try {
            $class = "scMVC\Controllers\\$controller";
            $controller = new $class();
            $controller->$method(...$parameters);
        } catch (\Exception $err) {
            die($err->getMessage());
        }

/* 
        var_dump($httpverb);
        var_dump($controller);
        var_dump($method);
        var_dump($parameters); */

    }
}