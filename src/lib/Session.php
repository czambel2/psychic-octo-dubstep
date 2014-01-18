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

	public function offsetGet($offset) {
		if(array_key_exists($offset, $this->parameters)) {
			return $this->parameters[$offset];
		} else {
			return null;
		}
	}

	public function offsetSet($offset, $value) {
		$this->parameters[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->parameters[$offset]);
	}

	public function get($key) {
		return $this->offsetGet($key);
	}

	public function set($key, $value) {
		$this->offsetSet($key, $value);
	}

	public function is($key) {
		return (bool) $this->get($key);
	}
}