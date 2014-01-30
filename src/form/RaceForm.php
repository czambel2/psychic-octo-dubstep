<?php

class RaceForm extends Form {
	protected function validate() {
		$this->check()->required('date');
		$this->check()->date('date');

		$this->check()->required('circuit1');
		$this->check()->integer('circuit1');

		$this->check()->required('circuit2');
		$this->check()->integer('circuit2');

		$this->check()->required('circuit3');
		$this->check()->integer('circuit3');
	}
}