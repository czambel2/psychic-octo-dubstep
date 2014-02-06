<?php

class ArrivalForm extends Form {
	/**
	 * V�rifie si les donn�es entr�es par l'utilisateur sont valides.
	 * @return boolean true si les donn�es sont valides, false sinon.
	 */
	protected function validate()
	{
		$this->check()->required('cyclistName');
	}
}