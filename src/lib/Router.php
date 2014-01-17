<?php

/**
 * Le routeur permet d'associer un tuple (contrôleur, action) à une URL donnée.
 */
abstract class Router {

	/**
	 * Récupère le contrôleur, l'action et les paramètres associés à une URL donnée.
	 * @param string $url L'URL demandée par l'utilisateur.
	 * @return array Un tableau décrivant le contrôleur, l'action et les paramètres.
	 */
	public static function parseUrl($url) {

		// Premièrement, on enlève de l'URL à analyser le répertoire de base
		// Par exemple, si le répertoire de base du site est /lionne/
		// et que l'on demande l'URL /lionne/accueil, on récupère uniquement "accueil".
		$url = preg_replace("#^" . preg_quote(Config::get('basePath')) . '#', '', $url);

		$returnValue = array();
		$parameters = array();

		// On analyse l'URL pour voir si elle correspond à une route
		if(preg_match("#^/$#", $url)) {
			// Page d'accueil
			$route = "home.index";
		} elseif(preg_match("#^/connexion$#", $url)) {
			// Formulaire de connexion
			$route = "login.showForm";
		} else {
			// L'URL ne correspond à aucune route : on lève une exception
			throw new Http404Exception($url);
		}

		// On convertit le nom du contrôleur, et de l'action
		$controllerAndAction = explode('.', $route);
		$returnValue["controller"] = lcfirst($controllerAndAction[0] . "Controller");
		$returnValue["action"] = $controllerAndAction[1];

		// On ajoute les paramètres GET (présents après le point d'interrogation dans l'URL)
		$returnValue["parameters"] = array_merge($parameters, $_GET);

		return $returnValue;
	}

	public static function generateUrl($controller, $action, array $parameters = array()) {

		$url = Config::get('basePath');

		switch($controller . '.' . $action) {
			case 'home.index':
				$url = '/';
				break;
			case 'login.showForm':
				$url = '/connexion';
				break;
		}

		return $url;

	}

}