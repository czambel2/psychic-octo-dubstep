<?php

/**
 * Représente un message d'erreur affiché à l'utilisateur.
 */
class Flash {
	/**
	 * Affiche un message standard (sur fond bleu).
	 */
	const FLASH_STANDARD = '';

	/**
	 * Affiche un message de succès (sur fond vert).
	 */
	const FLASH_SUCCESS = 'success';

	/**
	 * Affiche un message d'alerte (sur fond rouge).
	 */
	const FLASH_ALERT = 'alert';

	/**
	 * Affiche un message secondaire (sur fond gris).
	 */
	const FLASH_SECONDARY = 'secondary';

	/**
	 * @var string Le message à afficher à l'écran.
	 */
	protected $message;

	/**
	 * @var string Le type de message à afficher.
	 */
	protected $type;

	/**
	 * @var bool S'il faut ou non afficher la croix pour fermer le message.
	 */
	protected $close;

	/**
	 * Crée un nouveau message.
	 * @param string $message Le message à afficher.
	 * @param string $type Le type de message à afficher.
	 * @param bool $close S'il faut ou non afficher la croix pour fermer le message.
	 */
	public function __construct($message, $type = self::FLASH_STANDARD, $close = true) {
		$this->message = $message;
		$this->type = $type;
		$this->close = $close;
	}

	/**
	 * Récupère le code HTML du message.
	 */
	public function __toString() {
		if($this->close) {
			$close = '<a href="" class="close">&times;</a>';
		} else {
			$close = '';
		}

		return <<<EOF
	<div class="alert-box {$this->type}">
		{$this->message}
		{$close}
	</div>
EOF;

	}
}