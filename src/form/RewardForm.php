<?php

class RewardForm extends Form {

	/**
	 * Vérifie si les données entrées par l'utilisateur sont valides.
	 * @return boolean true si les données sont valides, false sinon.
	 */
	protected function validate() {
		$this->check()->required('rewardLabel');
		$this->check()->length('rewardLabel', null, 45);
	}
}