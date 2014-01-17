<?php

class Http404Exception extends Exception {
	public function __construct($requestedUrl) {
		parent::__construct('Impossible de trouver la page <code>' . $requestedUrl . '</code> demandée.', 404);
	}
}