<?php

class RaceForm extends Form {
	protected function validate() {
		$this->check()->required('date');
		$this->check()->date('date');

		$this->check()->required('circuit1');
		$this->check()->integer('circuit1');
		$this->check()->between('circuit1', 1, 1000);

		$this->check()->required('circuit2');
		$this->check()->integer('circuit2');
		$this->check()->between('circuit2', 1, 1000);

		$this->check()->required('circuit3');
		$this->check()->integer('circuit3');
		$this->check()->between('circuit3', 1, 1000);
	}
}