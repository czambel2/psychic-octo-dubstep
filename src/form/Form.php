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

	/**
	 * Retourne le code HTML permettant de mettre un champ en erreur.
	 * Cette méthode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @return null|string Le code HTML si le champ comporte une erreur, null sinon.
	 */
	protected function errorClass($field) {
		if($this->hasError($field)) {
			return ' class="error" ';
		} else {
			return null;
		}
	}

	/**
	 * Retourne le code HTML permettant d'afficher le message d'erreur correspondant à un champ.
	 * Cette méthode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @return null|string Le code HTML si le champ comporte une erreur, null sinon.
	 */
	protected function errorMessage($field) {
		if($this->hasError($field)) {
			return '<small class="error">' . $this->getError($field) . '</small>';
		} else {
			return null;
		}
	}

	/**
	 * Retourne le code HTML permettant de cocher automatiquement un élément HTML.
	 * Cette méthode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @param string $current La valeur du champ en cours.
	 * @return null|string Le code HTML si le champ est coché, null sinon.
	 */
	protected function valueChecked($field, $current) {
		if(array_key_exists($field, $this->data) and $this->data[$field] == $current) {
			return ' checked="checked" ';
		} else {
			return null;
		}
	}

	/**
	 * Retourne le code HTML permettant de sélectionner automatiquement un élément HTML.
	 * Cette méthode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @param string $current La valeur du champ en cours.
	 * @return null|string Le code HTML si le champ est sélectionné, null sinon.
	 */
	protected function valueSelected($field, $current) {
		if(array_key_exists($field, $this->data) and $this->data[$field] == $current) {
			return ' selected="selected" ';
		} else {
			return null;
		}
	}

	/**
	 * Retourne la valeur échappée d'un champ.
	 * Cette méthode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @return null|string La valeur échappée si le champ existe, null sinon.
	 */
	protected function valueEscaped($field) {
		if(array_key_exists($field, $this->data)) {
			return htmlspecialchars($this->data[$field]);
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
	 * Récupère la valeur d'un champ.
	 * @param string $field Le nom du champ.
	 * @return string|null La valeur du champ.
	 */
	public function getData($field) {
		if(array_key_exists($field, $this->data)) {
			return $this->data[$field];
		} else {
			return null;
		}
	}

	/**
	 * Définit la valeur d'un champ.
	 * @param string $field Le nom du champ.
	 * @param string $value La valeur du champ.
	 */
	public function setData($field, $value) {
		$this->data[$field] = $value;
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