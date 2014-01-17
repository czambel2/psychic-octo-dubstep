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
	 * Ajoute un message d'erreur au champ spécifié.
	 * @param string $field Le nom du champ.
	 * @param string $error Le message d'erreur à afficher.
	 */
	public function addError($field, $error) {
		$this->errors[$field] = $error;
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
	public abstract function validate();

	/**
	 * Récupère le code HTML du formulaire.
	 * @return string le code HTML du formulaire.
	 */
	public abstract function getHtml();
}