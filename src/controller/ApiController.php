<?php

class ApiController extends Controller {
	public function __construct() {
		Layout::getInstance()->disable();
		header("Content-Type: application/json, charset=iso-8859-1");
	}

	public function autocompleteCyclists() {
		if(array_key_exists('term', $_GET)) {
			$db = DB::getInstance();

			$_GET['term'] = utf8_decode($_GET['term']);

			$q = $db->prepare("SELECT TOP 10 c.numcyc, c.nom, c.prenom FROM cycliste c WHERE c.nom LIKE :lastName OR c.prenom LIKE :firstName");
			$q->bindValue('lastName', $_GET['term'] . '%');
			$q->bindValue('firstName', $_GET['term'] . '%');
			$q->execute();
			$results = $q->fetchAll();

			$cyclistes = array();
			foreach ($results as $cycliste) {
				$fullName = utf8_encode($cycliste["nom"] . " " . $cycliste["prenom"]);
				$cyclistes[] = $fullName;
			}

			echo json_encode($cyclistes);
		} else {
			echo '[ ]';
		}
	}
}