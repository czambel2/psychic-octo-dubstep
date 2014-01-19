<?php

class RouterException extends Exception {
	public function __construct($route) {
		$errorMessage = "La route <code>$route</code> n'a pas pu �tre trouv�e.";

		parent::__construct($errorMessage);
	}
}