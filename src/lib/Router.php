<?php

/**
 * Le routeur permet d'associer un tuple (contrôleur, action) à une URL donnée.
 */
abstract class Router {

	/**
	 * Contient toutes les routes.
	 *
	 * C'est un tableau de tableaux.
	 * @var array(array)
	 */
	protected static $routes = array(
		'home' => array(
			'index' => '/',
		),
		'login' => array(
			'showForm' => '/connexion',
			'logout' => '/deconnexion',
		),
		'api' => array(
			'editReward' => '/api/modifier-recompense',
		),
		'race' => array(
			'index' => '/courses/liste',
			'edit' => '/courses/modifier',
		),
		'thisRace' => array(
			'status' => '/course/etat',
			'rewards' => '/course/recompenses',
			'addReward' => '/course/recompenses/ajouter'
		),
		'cyclist' => array(
			'index' => '/cyclistes/liste',
			'add' => '/cyclistes/ajouter',
		),
		'display' => array(
			'cyclists' => '/impression/liste-cyclistes',
		),

	);

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
		$url = preg_replace("#(\?.+)$#", '', $url);

		$parameters = array();
		$route = null;

		// On analyse l'URL pour voir si elle correspond à une route
		foreach(self::$routes as $catName => $category) {
			$search = array_search($url, $category);
			if(false !== $search) {
				$route = $catName . "." . $search;
			}
		}

		if(!$route) {
			// L'URL ne correspond à aucune route : on lève une exception
			throw new NoRouteForUrlException($url);
		}

		return self::parseRoute($route, $parameters);
	}

	/**
	 * Convertit une route en tuple [contrôleur, action, paramètres]
	 * @param string $route La route demandée.
	 * @param array $parameters Les paramètres.
	 * @return array Le tableau de retour.
	 */
	public static function parseRoute($route, $parameters = array()) {
		$returnValue = array();

		$controllerAndAction = explode('.', $route);
		$returnValue["controllerShort"] = $controllerAndAction[0];
		$returnValue["controller"] = lcfirst($controllerAndAction[0] . "Controller");
		$returnValue["action"] = $controllerAndAction[1];

		$returnValue["parameters"] = $parameters;

		return $returnValue;
	}

	public static function generateUrl($route, array $parameters = array()) {
		$url = Config::get('basePath');

		$returnValue = self::parseRoute($route, $parameters);

		if(array_key_exists($returnValue["controllerShort"], self::$routes) and array_key_exists($returnValue["action"], self::$routes[$returnValue["controllerShort"]])) {
			$url .= self::$routes[$returnValue["controllerShort"]][$returnValue["action"]];
		} else {
			throw new RouterException($route);
		}

		// On rajoute les paramètres GET
		if(count($parameters)) {
			$url .= '?';

			foreach($parameters as $key => $value) {
				if($value !== reset($parameters)) {
					$url .= '&';
				}

				$url .= urlencode($key) . '=' . urlencode($value);
			}
		}

		return $url;
	}

}