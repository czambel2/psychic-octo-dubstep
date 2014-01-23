<?php

/**
 * Représente un formulaire de saisie.
 */
abstract class Form {
	/**
	 * @var array Les champs du formulaire.
	 */
	protected $fields = array();

	/**
	 * @var array Les données entrées par l'utilisateur.
	 */
	protected $data = array();

	/**
	 * @var array Les erreurs du formulaire.
	 */
	protected $errors = array();

	/**
	 * @var bool Définit si le formulaire a été validé ou non.
	 */
	protected $isValidated = false;

	/**
	 * Ajoute un message d'erreur au champ spécifié.
	 * @param string $field Le nom du champ.
	 * @param string $error Le message d'erreur à afficher.
	 */
	public function addError($field, $error) {
		$this->errors[$field] = $error;
	}

	/**
	 * Vérifie si le champ fourni en paramètre a un message d'erreur.
	 * @param string $field Le nom du champ.
	 * @return boolean si le champ fourni en paramètre a un message d'erreur.
	 */
	public function hasError($field) {
		return array_key_exists($field, $this->errors);
	}

	/**
	 * Récupère le message d'erreur associé au champ.
	 * @param string $field Le nom du champ.
	 * @return string le message d'erreur à afficher.
	 */
	public function getError($field) {
		return $this->errors[$field];
	}

	protected function errorClass($field) {
		if($this->hasError($field)) {
			return 'class="error" ';
		} else {
			return null;
		}
	}

	protected function errorMessage($field) {
		if($this->hasError($field)) {
			return '<small class="error">' . $this->getError($field) . '</small>';
		} else {
			return null;
		}
	}

	/**
	 * Vérifie si le formulaire est valide (i.e. il ne contient aucun message d'erreur)
	 * @return boolean si le formulaire est valide ou non.
	 */
	public function isValid() {
		if(!$this->isValidated) {
			$this->validate();
		}

		return count($this->errors) == 0;
	}

	/**
	 * Lie les entrées de l'utilisateur aux champs du formulaire.
	 * @param array $data Les données entrées par l'utilisateur.
	 */
	public function bind(array $data) {
		$this->data = $data;
	}

	/**
	 * Vérifie si les données entrées par l'utilisateur sont valides.
	 * @return boolean true si les données sont valides, false sinon.
	 */
	protected abstract function validate();

	/**
	 * Récupère le code HTML du formulaire.
	 * @return string le code HTML du formulaire.
	 */
	public abstract function __toString();
}