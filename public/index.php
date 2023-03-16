<?php

session_start();

use scMVC\System\Router;

require_once ('../vendor/autoload.php');

Router::dispatch();

