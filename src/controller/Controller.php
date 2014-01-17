<?php

class Controller {
	public function render($viewName, array $parameters = array()) {
		require_once '../src/views/' . $viewName . '.php';
	}
}