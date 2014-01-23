<?php

/**
 * Repr�sente un formulaire de saisie.
 */
abstract class Form {
	/**
	 * @var array Les champs du formulaire.
	 */
	protected $fields = array();

	/**
	 * @var array Les donn�es entr�es par l'utilisateur.
	 */
	protected $data = array();

	/**
	 * @var array Les erreurs du formulaire.
	 */
	protected $errors = array();

	/**
	 * @var bool D�finit si le formulaire a �t� valid� ou non.
	 */
	protected $isValidated = false;

	/**
	 * Ajoute un message d'erreur au champ sp�cifi�.
	 * @param string $field Le nom du champ.
	 * @param string $error Le message d'erreur � afficher.
	 */
	public function addError($field, $error) {
		$this->errors[$field] = $error;
	}

	/**
	 * V�rifie si le champ fourni en param�tre a un message d'erreur.
	 * @param string $field Le nom du champ.
	 * @return boolean si le champ fourni en param�tre a un message d'erreur.
	 */
	public function hasError($field) {
		return array_key_exists($field, $this->errors);
	}

	/**
	 * R�cup�re le message d'erreur associ� au champ.
	 * @param string $field Le nom du champ.
	 * @return string le message d'erreur � afficher.
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
	 * V�rifie si le formulaire est valide (i.e. il ne contient aucun message d'erreur)
	 * @return boolean si le formulaire est valide ou non.
	 */
	public function isValid() {
		if(!$this->isValidated) {
			$this->validate();
		}

		return count($this->errors) == 0;
	}

	/**
	 * Lie les entr�es de l'utilisateur aux champs du formulaire.
	 * @param array $data Les donn�es entr�es par l'utilisateur.
	 */
	public function bind(array $data) {
		$this->data = $data;
	}

	/**
	 * V�rifie si les donn�es entr�es par l'utilisateur sont valides.
	 * @return boolean true si les donn�es sont valides, false sinon.
	 */
	protected abstract function validate();

	/**
	 * R�cup�re le code HTML du formulaire.
	 * @return string le code HTML du formulaire.
	 */
	public abstract function __toString();
}