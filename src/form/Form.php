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

	/**
	 * Retourne le code HTML permettant de mettre un champ en erreur.
	 * Cette m�thode est un helper HTML.
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
	 * Retourne le code HTML permettant d'afficher le message d'erreur correspondant � un champ.
	 * Cette m�thode est un helper HTML.
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
	 * Retourne le code HTML permettant de cocher automatiquement un �l�ment HTML.
	 * Cette m�thode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @param string $current La valeur du champ en cours.
	 * @return null|string Le code HTML si le champ est coch�, null sinon.
	 */
	protected function valueChecked($field, $current) {
		if(array_key_exists($field, $this->data) and $this->data[$field] == $current) {
			return ' checked="checked" ';
		} else {
			return null;
		}
	}

	/**
	 * Retourne le code HTML permettant de s�lectionner automatiquement un �l�ment HTML.
	 * Cette m�thode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @param string $current La valeur du champ en cours.
	 * @return null|string Le code HTML si le champ est s�lectionn�, null sinon.
	 */
	protected function valueSelected($field, $current) {
		if(array_key_exists($field, $this->data) and $this->data[$field] == $current) {
			return ' selected="selected" ';
		} else {
			return null;
		}
	}

	/**
	 * Retourne la valeur �chapp�e d'un champ.
	 * Cette m�thode est un helper HTML.
	 * @param string $field Le nom du champ.
	 * @return null|string La valeur �chapp�e si le champ existe, null sinon.
	 */
	protected function valueEscaped($field) {
		if(array_key_exists($field, $this->data)) {
			return htmlspecialchars($this->data[$field]);
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
	 * R�cup�re la valeur d'un champ.
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
	 * D�finit la valeur d'un champ.
	 * @param string $field Le nom du champ.
	 * @param string $value La valeur du champ.
	 */
	public function setData($field, $value) {
		$this->data[$field] = $value;
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