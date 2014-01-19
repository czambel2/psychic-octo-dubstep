<?php

class AutoloaderException extends Exception {
	public function __construct($className, array $directories) {
		$errorMessage = "La classe $className est introuvable (r�pertoires scann�s : ";

		foreach($directories as $directory) {
			$errorMessage .= "<code>$directory</code>, ";
		}

		$errorMessage = substr($errorMessage, 0, strlen($errorMessage) - 2);
		$errorMessage .= ')';

		parent::__construct($errorMessage);
	}
}