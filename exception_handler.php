<?php

set_exception_handler(function(Exception $ex) {

	// On définit les variables pour la pseudo template
	$basePath = Config::get('basePath');
	$errorMessage = $ex->getMessage();
	$errorTrace = $ex->getTraceAsString();

	header("Content-Type: text/html, charset=windows-1252");

	// On envoie les headers
	switch($ex->getCode()) {
		case 403:
			header('HTTP/1.1 403 Forbidden');
			$errorTitle = "Accès refusé";
			break;
		case 404:
			header('HTTP/1.1 404 Not Found');
			$errorTitle = "Page non trouvée";
			break;
		default:
			header('HTTP/1.1 500 Internal Server Error');
			$errorTitle = "Erreur interne du serveur";
			break;
	}

	// On désactive l'affichage du design
	Layout::getInstance()->disable();

	// On appelle la pseudo template
	require_once 'exception_handler.tpl';
});