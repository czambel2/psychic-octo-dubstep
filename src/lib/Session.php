<?php

/**
 * Permet d'acc�der aux variables de session.
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
	 * R�cup�re l'instance actuelle de la session.
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
	 * D�termine si un �l�ment existe dans la session.
	 * @param string $offset La cl� de l'�l�ment.
	 * @return bool Si l'�l�ment existe.
	 */
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->parameters);
	}

	/**
	 * R�cup�re un �l�ment de la session.
	 * @param string $offset La cl� de l'�l�ment.
	 * @return mixed|null L'�l�ment.
	 */
	public function offsetGet($offset) {
		if(array_key_exists($offset, $this->parameters)) {
			return $this->parameters[$offset];
		} else {
			return null;
		}
	}

	/**
	 * D�finit un �l�ment dans la session.
	 * @param string $offset La cl� de l'�l�ment.
	 * @param mixed $value La valeur � d�finir.
	 */
	public function offsetSet($offset, $value) {
		$this->parameters[$offset] = $value;
	}

	/**
	 * Supprime un �l�ment de la session.
	 * @param string $offset La cl� de l'�l�ment.
	 */
	public function offsetUnset($offset) {
		unset($this->parameters[$offset]);
	}

	/**
	 * R�cup�re un �l�ment de la session.
	 * @param string $key La cl� de l'�l�ment.
	 * @return mixed|null L'�l�ment.
	 */
	public function get($key) {
		return $this->offsetGet($key);
	}

	/**
	 * D�finit un �l�ment dans la session.
	 * @param string $key La cl� de l'�l�ment.
	 * @param mixed $value La valeur � d�finir.
	 */
	public function set($key, $value) {
		$this->offsetSet($key, $value);
	}

	/**
	 * R�cup�re un �l�ment de la session sous forme bool�enne.
	 * @param string $key La cl� de l'�l�ment.
	 * @return bool L'�l�ment sous forme bool�enne, ou false si l'�l�ment n'existe pas.
	 */
	public function is($key) {
		return (bool) $this->get($key);
	}

	/**
	 * Ajoute un �l�ment dans un tableau contenu dans un �l�ment de la session.
	 * @param string $key La cl� de l'�l�ment.
	 * @param mixed $value L'�l�ment � ajouter.
	 */
	public function add($key, $value) {
		if(!array_key_exists($key, $this->parameters)) {
			$this->parameters[$key] = array();
		}

		if(is_array($this->parameters[$key])) {
			$this->parameters[$key][] = $value;
		} else {
			throw new Exception("L'�l�ment <code>$key</code> de la session existe d�j� et n'est pas un tableau.");
		}
	}

	/**
	 * R�cup�re puis supprime l'�l�ment `flash'.
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