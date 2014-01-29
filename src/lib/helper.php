<?php

/**
 * G�n�re une URL.
 * @param string $route la route � appeler.
 * @param array $parameters les param�tres.
 * @return string l'URL retourn�e.
 */
function url($route, array $parameters = array()) {
	return Router::generateUrl($route, $parameters);
}

/**
 * R�cup�re le dossier vers la racine du site.
 * @return string le dossier vers la racine du site.
 */
function basePath() {
	return Config::get('basePath');
}

/**
 * �chappe une cha�ne de caract�res pour l'afficher � l'�cran.
 * @param string $string La cha�ne de caract�res � afficher.
 * @return string La cha�ne de caract�res �chapp�e.
 */
function e($string) {
	return htmlspecialchars($string);
}