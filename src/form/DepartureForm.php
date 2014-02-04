<?php

class DepartureForm extends Form {
	function __construct() {
		parent::__construct();
		$this->data['circuit'] = null;
	}

	protected function validate() {
		$this->check()->required('cyclistName');

		$this->check()->required('circuit');
		$this->check()->inList('circuit', array(1, 2, 3));
	}
}