<?php

/**
 * Contient diverses fonctions utiles.
 */
abstract class Utility {
	/**
	 * Redirige vers une URL.
	 * @param string $url L'URL à rediriger.
	 */
	public static function redirect($url) {
		ob_end_clean();

		$url = preg_replace("#\r|\n#", "", $url);

		Layout::getInstance()->disable();

		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $url);
		exit;
	}

	/**
	 * Redirige vers une route.
	 * @param string $route La route vers laquelle on doit rediriger.
	 * @param array $parameters Les paramètres de la route.
	 */
	public static function redirectRoute($route, array $parameters = array()) {
		self::redirect(Router::generateUrl($route, $parameters));
	}
}