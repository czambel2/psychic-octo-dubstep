<?php

class CloseRaceForm extends Form {
	public function __construct() {
		parent::__construct();
		$this->data['hour'] = new DateTime();
	}

	protected function validate() {
		$this->check()->time('hour');
	}
}