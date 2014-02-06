<?php

class Controller {
	public function render($viewName, array $parameters = array()) {
		extract($parameters);
		require_once '../src/views/' . $viewName . '.php';
	}

	public function call($route, array $parameters = array()) {
		$currentData = ob_get_clean();
		ob_start();

		$requestedRoute = Router::parseRoute($route, array_merge(array('embedded' => true), $parameters));

		$controller = new $requestedRoute["controller"]();
		call_user_func_array(array($controller, $requestedRoute["action"]), $requestedRoute["parameters"]);

		$callResults = ob_get_clean();

		ob_start();
		echo $currentData;

		return $callResults;
	}

	/**
	 * Récupère le numéro de la dernière course
	 */
	protected function getLastRaceNumber()
	{
		$db = DB::getInstance();
		$q = $db->query('SELECT MAX(NUMCOURSE) AS nb FROM COURSE');
		$q->execute();
		return $q->fetch()['nb'];
	}
}