<?php

require_once 'src/lib/AutoloaderException.php';
require_once 'exception_handler.php';
require_once 'src/lib/helper.php';

/**
 * Enregistre une fonction de callback pour faire un require du fichier approprié.
 * Permet d'éviter d'avoir à rajouter des "include/require" au début de chaque fichier.
 */
spl_autoload_register(function($className) {
	$directories = array('src/lib/', 'src/controller/', 'src/form/');

	// On supprime les caractères interdits dans les noms de classe
	$className = preg_replace('/[^a-zA-Z0-9]/', '', $className);

	foreach($directories as $directory) {
		// On vérifie dans chaque répertoire si le fichier existe
		$filename = __DIR__ . '/' . $directory . $className . '.php';
		if(file_exists($filename)) {
			require_once $filename;
			return;
		}
	}

	throw new AutoloaderException($className, $directories);
});