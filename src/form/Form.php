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
	 * @var Validation La classe de validation correspondant au formulaire.
	 */
	protected $validation;

	/**
	 * @var array Les donn�es compl�mentaires.
	 */
	protected $miscData = array();

	/**
	 * Constructeur.
	 */
	public function __construct() {
		$this->validation = new Validation($this);
	}

	/**
	 * Ajoute un message d'erreur au champ sp�cifi�.
	 * @param string $field Le nom du champ.
	 * @param string $error Le message d'erreur � afficher.
	 */
	public function addError($field, $error) {
		if(!array_key_exists($field, $this->errors)) {
			// On emp�che la cascade des erreurs (seule la premi�re sera prise en compte)
			$this->errors[$field] = $error;
		}
	}

	/**
	 * R�cup�re les valeurs de tous les champs du formulaire.
	 * @return array Les valeurs de tous les champs du formulaire.
	 */
	public function getAllData() {
		return $this->data;
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
			if($this->data[$field] instanceof DateTime) {
				// Si la valeur est une date, on la formate avant de l'afficher
				return $this->data[$field]->format('d/m/Y');
			} else {
				return htmlspecialchars($this->data[$field]);
			}
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
	 * Lie les informations de la base de donn�es aux champs du formulaire.
	 * @param array $data Les donn�es issues de la base de donn�es.
	 */
	public function bindDatabase(array $data) {
		$this->data = $data;
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
	 * Helper permettant d'appeler des fonctions de validation.
	 * @return Validation La classe Validation correspondant au formulaire.
	 */
	public function check() {
		return $this->validation;
	}

	/**
	 * R�cup�re une donn�e compl�mentaire.
	 * @param string $name Le nom de la donn�e.
	 * @return mixed La donn�e
	 */
	public function getMiscData($name) {
		return $this->miscData[$name];
	}

	/**
	 * D�finit une donn�e compl�mentaire.
	 * @param string $name Le nom de la donn�e.
	 * @param mixed $value La valeur de la donn�e.
	 */
	public function setMiscData($name, $value) {
		$this->miscData[$name] = $value;
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
	public function __toString() {
		$viewName = get_class($this);
		$viewName = preg_replace('#Form$#', '', $viewName);
		$viewName = lcfirst($viewName);

		// Petit hack pour �viter de m�langer le formulaire � la page
		$currentContent = ob_get_clean();
		ob_start();
		require_once "/../views/forms/$viewName.php";
		$returnValue = ob_get_clean();
		ob_start();
		echo $currentContent;

		return $returnValue;
	}
}