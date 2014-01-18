<?php

class Controller {
	public function render($viewName, array $parameters = array()) {
		extract($parameters);
		require_once '../src/views/' . $viewName . '.php';
	}
}