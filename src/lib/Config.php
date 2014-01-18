<?php

abstract class Config {
	protected static $configuration = array(
		// Le dossier vers la racine du site
		'basePath' => '',
		// Le mot de passe de l'application
		'password' => 'lionne',
	);

	/**
	 * Récupère un élément de la configuration du site.
	 * @param string $key La clé à récupérer.
	 * @return mixed La valeur récupérée, ou `null' si rien n'est trouvé.
	 */
	public static function get($key) {
		if(array_key_exists($key, self::$configuration)) {
			return self::$configuration[$key];
		} else {
			return null;
		}
	}

	/**
	 * Définit un élément dans la configuration du site.
	 * @param string $key La clé à modifier.
	 * @param mixed $value La nouvelle valeur.
	 */
	public static function set($key, $value) {
		self::$configuration[$key] = $value;
	}
}