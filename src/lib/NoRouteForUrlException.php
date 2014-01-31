<?php

class NoRouteForUrlException extends Exception {
	public function __construct($requestedUrl) {
		parent::__construct('Impossible de trouver la page <code>' . $requestedUrl . '</code> demand�e.', 404);
	}
}