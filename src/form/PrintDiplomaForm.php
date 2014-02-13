<?php

class PrintDiplomaForm extends Form {

	protected function validate() {
		if($this->data['action'] == 'printOne') {
			$this->check()->required('cyclistName');
		}
	}
}