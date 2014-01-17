<?php

/**
 * Génère une URL.
 * @param string $controller le contrôleur à appeler.
 * @param string $action l'action à appeler.
 * @param array $parameters les paramètres.
 * @return string l'URL retournée.
 */
function url($controller, $action, array $parameters = array()) {
	return Router::generateUrl($controller, $action, $parameters);
}

/**
 * Récupère le dossier vers la racine du site.
 * @return string le dossier vers la racine du site.
 */
function basePath() {
	return Config::get('basePath');
}