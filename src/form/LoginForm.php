<?php

/**
 * Le formulaire de connexion.
 */
class LoginForm extends Form {
	public function __construct() {
		$this->fields = array('password');
	}

	public function validate() {
		if($this->fields['password'] != Config::get('password')) {
			$this->addError('password', 'Le mot de passe entré est incorrect.');
		}

		return $this->isValid();
	}

	public function getHtml() {

	}
}