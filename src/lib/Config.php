<?php

abstract class Config {
	protected static $configuration = array(
		// Le dossier vers la racine du site
		'basePath' => '',
		// Le mot de passe de l'application
		'password' => 'lionne',
	);

	/**
	 * R�cup�re un �l�ment de la configuration du site.
	 * @param string $key La cl� � r�cup�rer.
	 * @return mixed La valeur r�cup�r�e, ou `null' si rien n'est trouv�.
	 */
	public static function get($key) {
		if(array_key_exists($key, self::$configuration)) {
			return self::$configuration[$key];
		} else {
			return null;
		}
	}

	/**
	 * D�finit un �l�ment dans la configuration du site.
	 * @param string $key La cl� � modifier.
	 * @param mixed $value La nouvelle valeur.
	 */
	public static function set($key, $value) {
		self::$configuration[$key] = $value;
	}
}