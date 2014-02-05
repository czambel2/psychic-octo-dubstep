<?php

class SearchCyclistForm extends Form {
	protected function validate() {
		$this->check()->required('cyclistName');
	}
}