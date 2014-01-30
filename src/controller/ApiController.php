<?php

class ApiController extends Controller {
	public function __construct() {
		Layout::getInstance()->disable();
		//header("Content-Type: application/json, charset=iso-8859-1");
	}

	public function editReward() {
		if(!array_key_exists('NbParticipation', $_POST) or !array_key_exists('LibRecompense', $_POST)) {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('res' => 'nok'));
			exit;
		}

		$nbParticipation = $_POST['NbParticipation'];
		$libRecompense = $_POST['LibRecompense'];

		$db = DB::getInstance();
		$q = $db->prepare('UPDATE RECOMPENSE SET LIBRECOMPENSE = :libRecompense WHERE NBPARTICIPATION = :nbParticipation');
		$q->bindValue('nbParticipation', $nbParticipation);
		$q->bindValue('libRecompense', $libRecompense);

		try {
			$q->execute();
			echo json_encode(array('res' => 'ok'));
		} catch(PDOException $ex) {
			header("HTTP/1.1 500 Internal Server Error");
			echo json_encode(array('res' => 'nok'));
		}
	}
}