<?php

class DB extends PDO {
	/**
	 * @var DB l'instance actuelle de la base de données.
	 */
	protected static $instance;

	/**
	 * Récupère l'instance actuelle de la base de données.
	 * @return DB l'instance actuelle de la base de données.
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		parent::__construct(
			Config::get('db.dsn'),
			Config::get('db.username'),
			Config::get('db.password')
		);

		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}