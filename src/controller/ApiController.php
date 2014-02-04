<?php

class ApiController extends Controller {
	public function __construct() {
		Layout::getInstance()->disable();
		header("Content-Type: application/json, charset=iso-8859-1");
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

	public function autocompleteCyclists() {
		if(array_key_exists('term', $_GET)) {
			$db = DB::getInstance();

			$_GET['term'] = utf8_decode($_GET['term']);

			$q = $db->prepare("SELECT TOP 10 c.numcyc, c.nom, c.prenom FROM cycliste c WHERE c.nom LIKE :lastName OR c.prenom LIKE :firstName OR c.numcyc = :cyclistId");
			$q->bindValue('lastName', $_GET['term'] . '%');
			$q->bindValue('firstName', $_GET['term'] . '%');
			$q->bindValue('cyclistNumber', (int) $_GET['term'], PDO::PARAM_INT);
			$q->execute();
			$results = $q->fetchAll();

			$cyclistes = array();
			foreach ($results as $cycliste) {
				$fullName = utf8_encode($cycliste["nom"] . " " . $cycliste["prenom"]);
				$cyclistes[] = $fullName;
			}

			echo json_encode($cyclistes);
		} else {
			echo json_encode(array());
		}
	}
}