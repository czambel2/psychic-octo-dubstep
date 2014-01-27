<?php

class CyclistForm extends Form {
	function __construct() {
		parent::__construct();
		$this->data['title'] = 'M';
		$this->data['category'] = ' ';
	}

	protected function validate() {
		$this->check()->required('title');
		$this->check()->inList('title', array('M', 'MME', 'MLLE'));

		$this->check()->required('lastName');
		$this->check()->length('lastName', null, 25);

		$this->check()->required('firstName');
		$this->check()->length('lastName', null, 20);

		$this->check()->email('email');

		$this->check()->date('birthDate');

		$this->check()->required('address');
		$this->check()->length('address', null, 35);

		$this->check()->required('zipcode');
		$this->check()->length('zipcode', null, 5);

		$this->check()->required('city');
		$this->check()->length('city', null, 25);

		$this->check()->length('factory', null, 4);

		$this->check()->length('factoryAddress', null, 100);

		$this->check()->length('ascap', null, 7);

		$this->check()->required('category');
		$this->check()->inList('category', array(' ', 'ACT', 'CNJ', 'ECT', 'ENF', 'EXT', 'M', 'RET'));
	}
}