<?php

/**
 * Classe helper permettant de valider des champs.
 *
 * @property array $data Les données du formulaire.
 */
class Validation {
	/**
	 * @var Form Le formulaire à valider.
	 */
	protected $parent;

	/**
	 * Helper permettant de récupérer les données entrées dans le formulaire.
	 * @param string $name Le nom de la propriété à récupérer.
	 * @return mixed La propriété demandée.
	 */
	public function __get($name) {
		if($name == 'data') {
			return $this->parent->getAllData();
		} else {
			return null;
		}
	}

	/**
	 * Constructeur.
	 * @param Form $parent Le formulaire à valider.
	 */
	public function __construct(Form $parent) {
		$this->parent = $parent;
	}

	/**
	 * Vérifie si un champ est bien renseigné.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function required($field, $message = 'Ce champ est obligatoire.') {
		if(!array_key_exists($field, $this->data) or $this->data[$field] == null) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * Vérifie si un champ est égal à une valeur prédéfinie.
	 * @param string $field Le nom du champ.
	 * @param string $expected La valeur attendue.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function equals($field, $expected, $message = 'Ce champ est invalide.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and $this->data[$field] != $expected) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * Vérifie si un champ est présent dans une liste de valeurs prédéfinies.
	 * @param string $field Le nom du champ.
	 * @param array $list La liste des valeurs acceptées.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function inList($field, array $list, $message = 'Veuillez sélectionner une valeur de la liste.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !in_array($this->data[$field], $list)) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * Vérifie si un champ est dans la longueur requise.
	 * @param string $field Le nom du champ.
	 * @param integer $minLength La longueur minimale du champ (null si aucune)
	 * @param integer $maxLength La longueur maximale du champ (null si aucune)
	 * @param string $minMessage (optionnel) Le message d'erreur à afficher si le champ est trop court.
	 * @param string $maxMessage (optionnel) Le message d'erreur à afficher si le champ est trop long.
	 */
	public function length($field, $minLength, $maxLength, $minMessage = 'Ce champ doit comporter au moins %d caractère%s.', $maxMessage = 'Ce champ ne doit pas comporter plus de %d caractère%s.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null) {
			if($minLength !== null and strlen($this->data[$field]) < $minLength) {
				$this->parent->addError($field, sprintf($minMessage, $minLength, $minLength > 1 ? 's' : ''));
			} elseif ($maxLength !== null and strlen($this->data[$field]) > $maxLength) {
				$this->parent->addError($field, sprintf($maxMessage, $maxLength, $maxLength > 1 ? 's' : ''));
			}
		}
	}

	/**
	 * Vérifie si un champ correspond à une adresse e-mail valide.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function email($field, $message = 'L\'adresse e-mail entrée est invalide.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !preg_match('#^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$#i', $this->data[$field])) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * Vérifie si un champ correspond à une date valide.
	 * Cette méthode est un peu plus complexe car elle va transformer le champ en instance de classe DateTime.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function date($field, $message = 'La date entrée est invalide.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null) {
			$matches = array();
			if(preg_match('#^([0-9]{1,2})[/\- ]?([0-9]{1,2})[/\- ]?([0-9]{2,4})$#', $this->data[$field], $matches)) {
				try {
					if(strlen($matches[3]) == 2) {
						$matches[3] += 1900;
					}

					$dmyDate = $matches[1] . '/' . $matches[2] . '/' . $matches[3];
					$dateTime = DateTime::createFromFormat('d/m/Y', $dmyDate);
					if($dateTime->format('d/m/Y') != $dmyDate) {
						$this->parent->addError($field, $message);
					} else {
						$this->parent->setData($field, $dateTime);
					}
				} catch(Exception $ex) {
					$this->parent->addError($field, $message);
				}
			} else {
				$this->parent->addError($field, $message);
			}
		}
	}

	/**
	 * Vérifie si un champ est un entier.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur à afficher.
	 */
	public function integer($field, $message = 'Veuillez entrer un nombre.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !is_numeric($this->data[$field])) {
			$this->parent->addError($field, $message);
		}
	}
}