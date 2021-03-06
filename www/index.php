<?php

require_once '../autoloader.php';

Layout::getInstance();
Session::getInstance();

$requestedRoute = Router::parseUrl($_SERVER['REQUEST_URI']);

if(Session::getInstance()->is('logged') or $requestedRoute["controller"] == 'assetController') {
	$controller = new $requestedRoute["controller"]();
	call_user_func_array(array($controller, $requestedRoute["action"]), $requestedRoute["parameters"]);
} else {
	// Rediriger vers la page de connexion
	$controller = new LoginController();
	call_user_func(array($controller, 'showForm'));
}

