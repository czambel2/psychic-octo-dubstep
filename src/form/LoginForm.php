<?php

/**
 * Le formulaire de connexion.
 */
class LoginForm extends Form {
	protected function validate() {
		$this->check()->required('password');
		$this->check()->equals('password', Config::get('password'), 'Le mot de passe entré est incorrect.');
	}
}