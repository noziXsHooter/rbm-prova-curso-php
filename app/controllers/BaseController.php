<?php

namespace scMVC\Controllers;

abstract class BaseController
{
    public function view($view, $data = [])
    {
        // CHECA SE A DATA É UM ARRAY
        if(!is_array($data)){
            die("Data is not an array: " . var_dump($data));
        }

        // EXTRAI AS VARIÁVEIS
        extract($data);

        // INCLUI O ARQUIVO SE ELE EXISTIR
        if(file_exists("../app/views/$view.php")){
            require_once("../app/views/$view.php");
        } else {
            die("View não encontrada: " . $view);
        }
    }
}