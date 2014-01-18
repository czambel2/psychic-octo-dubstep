<?php

class RouterException extends Exception {
	public function __construct($route) {
		$errorMessage = "La route $route n'a pas pu être trouvée.";

		parent::__construct($errorMessage);
	}
}