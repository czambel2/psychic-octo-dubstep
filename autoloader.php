<?php

require_once 'src/lib/AutoloaderException.php';
require_once 'exception_handler.php';
require_once 'src/lib/helper.php';

/**
 * Enregistre une fonction de callback pour faire un require du fichier appropri�.
 * Permet d'�viter d'avoir � rajouter des "include/require" au d�but de chaque fichier.
 */
spl_autoload_register(function($className) {
	$directories = array('src/lib/', 'src/controller/', 'src/form/');

	// On supprime les caract�res interdits dans les noms de classe
	$className = preg_replace('/[^a-zA-Z0-9]/', '', $className);

	foreach($directories as $directory) {
		// On v�rifie dans chaque r�pertoire si le fichier existe
		$filename = __DIR__ . '/' . $directory . $className . '.php';
		if(file_exists($filename)) {
			require_once $filename;
			return;
		}
	}

	throw new AutoloaderException($className, $directories);
});