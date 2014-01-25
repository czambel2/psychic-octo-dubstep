<?php

/**
 * Permet d'accéder aux variables de session.
 */
class Session implements ArrayAccess {
	/**
	 * @var Session l'instance actuelle de Session.
	 */
	protected static $instance;

	/**
	 * @var array Le contenu de la session.
	 */
	protected $parameters = array();

	/**
	 * Récupère l'instance actuelle de la session.
	 * @return Session l'instance actuelle de la session.
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructeur.
	 */
	protected function __construct() {
		session_start();

		header("HTTP/1.1 200 OK");
		header("Content-Type: text/html; charset=iso-8859-1");

		$this->parameters = $_SESSION;
	}

	/**
	 * Destructeur.
	 */
	public function __destruct() {
		$_SESSION = $this->parameters;
	}

	/**
	 * Détermine si un élément existe dans la session.
	 * @param string $offset La clé de l'élément.
	 * @return bool Si l'élément existe.
	 */
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->parameters);
	}

	/**
	 * Récupère un élément de la session.
	 * @param string $offset La clé de l'élément.
	 * @return mixed|null L'élément.
	 */
	public function offsetGet($offset) {
		if(array_key_exists($offset, $this->parameters)) {
			return $this->parameters[$offset];
		} else {
			return null;
		}
	}

	/**
	 * Définit un élément dans la session.
	 * @param string $offset La clé de l'élément.
	 * @param mixed $value La valeur à définir.
	 */
	public function offsetSet($offset, $value) {
		$this->parameters[$offset] = $value;
	}

	/**
	 * Supprime un élément de la session.
	 * @param string $offset La clé de l'élément.
	 */
	public function offsetUnset($offset) {
		unset($this->parameters[$offset]);
	}

	/**
	 * Récupère un élément de la session.
	 * @param string $key La clé de l'élément.
	 * @return mixed|null L'élément.
	 */
	public function get($key) {
		return $this->offsetGet($key);
	}

	/**
	 * Définit un élément dans la session.
	 * @param string $key La clé de l'élément.
	 * @param mixed $value La valeur à définir.
	 */
	public function set($key, $value) {
		$this->offsetSet($key, $value);
	}

	/**
	 * Récupère un élément de la session sous forme booléenne.
	 * @param string $key La clé de l'élément.
	 * @return bool L'élément sous forme booléenne, ou false si l'élément n'existe pas.
	 */
	public function is($key) {
		return (bool) $this->get($key);
	}

	/**
	 * Ajoute un élément dans un tableau contenu dans un élément de la session.
	 * @param string $key La clé de l'élément.
	 * @param mixed $value L'élément à ajouter.
	 */
	public function add($key, $value) {
		if(!array_key_exists($key, $this->parameters)) {
			$this->parameters[$key] = array();
		}

		if(is_array($this->parameters[$key])) {
			$this->parameters[$key][] = $value;
		} else {
			throw new Exception("L'élément <code>$key</code> de la session existe déjà et n'est pas un tableau.");
		}
	}

	/**
	 * Récupère puis supprime l'élément `flash'.
	 * @return array(Flash)
	 */
	public function getFlashes() {
		if(array_key_exists('flash', $this->parameters)) {
			$flashes = $this->parameters['flash'];
			unset($this->parameters['flash']);
			return $flashes;
		} else {
			return array();
		}
	}

	public function addFlash(Flash $flash) {
		if(!array_key_exists('flash', $this->parameters)) {
			$this->parameters['flash'] = array();
		}

		$this->parameters['flash'][] = $flash;
	}
}