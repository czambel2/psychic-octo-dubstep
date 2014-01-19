<?php

/**
 * Permet d'afficher le design de l'application.
 */
class Layout {
	/**
	 * @var Layout l'instance actuelle de Session.
	 */
	protected static $instance;

	/**
	 * @var bool S'il faut afficher ou non le layout.
	 */
	protected $enabled = true;

	protected $type;

	protected $showMenu = true;

	/**
	 * Récupère l'instance actuelle du design de la page.
	 * @return Layout l'instance actuelle du design de la page.
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function showMenu($show) {
		$this->showMenu = (bool) $show;
	}

	/**
	 * Désactive l'affichage du design pour cette page.
	 */
	public function disable() {
		$this->enabled = false;
	}

	/**
	 * Active l'affichage du design pour cette page.
	 */
	public function enable() {
		$this->enabled = true;
	}

	/**
	 * Constructeur.
	 */
	protected function __construct() {
		$this->type = 'standard';

		ob_start();
	}

	public function __destruct() {
		$layoutContents = ob_get_clean();

		if($this->enabled) {
			$showMenu = $this->showMenu;
			require_once "/../views/layout.php" ;
		} else {
			echo $layoutContents;
		}
	}
}