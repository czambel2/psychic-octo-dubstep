<?php

/**
 * Le formulaire de connexion.
 */
class LoginForm extends Form {
	public function __construct() {
		$this->fields = array('password');
	}

	protected function validate() {
		if(!array_key_exists('password', $this->data) or $this->data['password'] != Config::get('password')) {
			$this->addError('password', 'Le mot de passe entré est incorrect.');
		}
	}

	public function __toString() {
		$html = <<<FORM
	<div class="row">
		<input type="hidden" name="form" value="login" />

		<div class="row">
			<p class="twelve columns">
				<label for="password">Mot de passe</label>
				<input type="password" name="data[password]" id="password" autofocus="autofocus"{$this->errorClass('password')} />
				{$this->errorMessage('password')}
			</p>
		</div>

		<div class="row">
			<p class="twelve columns text-centered">
				<button type="submit" class="button">Connexion</button>
			</p>
		</div>
	</div>
FORM;

		return $html;
	}
}