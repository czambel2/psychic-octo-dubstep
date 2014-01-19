<?php

/**
 * Génère une URL.
 * @param string $route la route à appeler.
 * @param array $parameters les paramètres.
 * @return string l'URL retournée.
 */
function url($route, array $parameters = array()) {
	return Router::generateUrl($route, $parameters);
}

/**
 * Récupère le dossier vers la racine du site.
 * @return string le dossier vers la racine du site.
 */
function basePath() {
	return Config::get('basePath');
}