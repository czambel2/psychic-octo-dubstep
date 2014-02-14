<?php

abstract class Config {
	protected static $configuration = array(
		// Le dossier vers la racine du site
		'basePath' => '',
		// Le mot de passe de l'application
		'password' => 'lionne',
		// Le DSN de la connexion à la base de données
		'db.dsn' => 'odbc:lionne',
		// Le nom d'utilisateur de connexion à la base de données
		'db.username' => null,
		// Le mot de passe de connexion à la base de données
		'db.password' => null,
		// Si true, les fichiers PDF générés seront téléchargés en attachement
		// Si false, ils seront affichés directement dans le navigateur
		'download.pdf' => true,
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