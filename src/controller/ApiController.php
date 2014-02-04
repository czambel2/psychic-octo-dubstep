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

			$q = $db->prepare("SELECT TOP 10 c.numcyc, c.nom, c.prenom FROM cycliste c WHERE
				c.nom LIKE :lastName OR
				c.prenom LIKE :firstName OR
				c.nom & ' ' & c.prenom LIKE :fullName1 OR
				c.prenom & ' ' & c.nom LIKE :fullName2 OR
				c.numcyc = :cyclistId");
			$q->bindValue('lastName', $_GET['term'] . '%');
			$q->bindValue('firstName', $_GET['term'] . '%');
			$q->bindValue('fullName1', '%' . $_GET['term'] . '%');
			$q->bindValue('fullName2', '%' . $_GET['term'] . '%');
			$q->bindValue('cyclistId', (int) $_GET['term'], PDO::PARAM_INT);
			$q->execute();
			$results = $q->fetchAll();

			$cyclistes = array();
			foreach ($results as $cycliste) {
				$fullName = utf8_encode($cycliste["nom"] . " " . $cycliste["prenom"] . " (" . $cycliste["numcyc"] . ")");
				$cyclistes[] = $fullName;
			}

			echo json_encode($cyclistes);
		} else {
			echo json_encode(array());
		}
	}

	public function cyclistDetails() {
		if(array_key_exists('cyclistId', $_GET)) {
			$db = DB::getInstance();
			$q = $db->prepare('SELECT c.numcyc, c.polit, c.nom, c.prenom, c.date_n, c.adresse, c.cod_post, c.ville
				FROM cycliste c WHERE c.numcyc = :cyclistId');
			$q->bindValue('cyclistId', $_GET['cyclistId']);
			$q->execute();

			if($cyclist = $q->fetch()) {
				echo json_encode(array(
					'cyclistId' => $cyclist['numcyc'],
					'title' => $cyclist['polit'],
					'lastName' => $cyclist['nom'],
					'firstName' => $cyclist['prenom'],
					'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', $cyclist['date_n'])->format('d/m/Y'),
					'address' => $cyclist['adresse'],
					'zipcode' => $cyclist['cod_post'],
					'city' => $cyclist['ville'],
				));
			} else {
				header("HTTP/1.1 404 Not Found");
				echo json_encode(array());
			}
		} else {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('res' => 'nok'));
		}
	}
}