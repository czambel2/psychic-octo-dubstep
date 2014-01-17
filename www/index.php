<?php

require_once '../autoloader.php';

Session::getInstance();
Layout::getInstance();

$requestedRoute = Router::parseUrl($_SERVER['REQUEST_URI']);

$controller = new $requestedRoute["controller"]();
call_user_func(array($controller, $requestedRoute["action"]), $requestedRoute["parameters"]);

