<?php

/**
 * Classe helper permettant de valider des champs.
 *
 * @property array $data Les donn�es du formulaire.
 */
class Validation {
	/**
	 * @var Form Le formulaire � valider.
	 */
	protected $parent;

	/**
	 * Helper permettant de r�cup�rer les donn�es entr�es dans le formulaire.
	 * @param string $name Le nom de la propri�t� � r�cup�rer.
	 * @return mixed La propri�t� demand�e.
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
	 * @param Form $parent Le formulaire � valider.
	 */
	public function __construct(Form $parent) {
		$this->parent = $parent;
	}

	/**
	 * V�rifie si un champ est bien renseign�.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function required($field, $message = 'Ce champ est obligatoire.') {
		if(!array_key_exists($field, $this->data) or $this->data[$field] == null) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * V�rifie si un champ est �gal � une valeur pr�d�finie.
	 * @param string $field Le nom du champ.
	 * @param string $expected La valeur attendue.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function equals($field, $expected, $message = 'Ce champ est invalide.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and $this->data[$field] != $expected) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * V�rifie si un champ est pr�sent dans une liste de valeurs pr�d�finies.
	 * @param string $field Le nom du champ.
	 * @param array $list La liste des valeurs accept�es.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function inList($field, array $list, $message = 'Veuillez s�lectionner une valeur de la liste.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !in_array($this->data[$field], $list)) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * V�rifie si un champ est dans la longueur requise.
	 * @param string $field Le nom du champ.
	 * @param integer $minLength La longueur minimale du champ (null si aucune)
	 * @param integer $maxLength La longueur maximale du champ (null si aucune)
	 * @param string $minMessage (optionnel) Le message d'erreur � afficher si le champ est trop court.
	 * @param string $maxMessage (optionnel) Le message d'erreur � afficher si le champ est trop long.
	 */
	public function length($field, $minLength, $maxLength, $minMessage = 'Ce champ doit comporter au moins %d caract�re%s.', $maxMessage = 'Ce champ ne doit pas comporter plus de %d caract�re%s.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null) {
			if($minLength !== null and strlen($this->data[$field]) < $minLength) {
				$this->parent->addError($field, sprintf($minMessage, $minLength, $minLength > 1 ? 's' : ''));
			} elseif ($maxLength !== null and strlen($this->data[$field]) > $maxLength) {
				$this->parent->addError($field, sprintf($maxMessage, $maxLength, $maxLength > 1 ? 's' : ''));
			}
		}
	}

	/**
	 * V�rifie si un champ correspond � une adresse e-mail valide.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function email($field, $message = 'L\'adresse e-mail entr�e est invalide.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !preg_match('#^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$#i', $this->data[$field])) {
			$this->parent->addError($field, $message);
		}
	}

	/**
	 * V�rifie si un champ correspond � une date valide.
	 * Cette m�thode est un peu plus complexe car elle va transformer le champ en instance de classe DateTime.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function date($field, $message = 'La date entr�e est invalide.') {
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
	 * V�rifie si un champ est un entier.
	 * @param string $field Le nom du champ.
	 * @param string $message (optionnel) Le message d'erreur � afficher.
	 */
	public function integer($field, $message = 'Veuillez entrer un nombre.') {
		if(array_key_exists($field, $this->data) and $this->data[$field] != null and !is_numeric($this->data[$field])) {
			$this->parent->addError($field, $message);
		}
	}
}