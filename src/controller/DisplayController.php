<?php

class DisplayController extends Controller {

	public function diploma() {

	}

	public function diplomaParameters() {

	}

	public function cyclists() {
		$db = DB::getInstance();
		$q = $db->query("SELECT c.numcyc, c.nom, c.prenom, c.adresse, c.ville FROM CYCLISTE c order by c.numcyc");
		$q->execute();

		$cyclistes = $q->fetchAll();

		$this->render("display.cyclists", array('cyclistes' => $cyclistes));
	}

	public function races() {

	}

	public function label() {

	}

	public function labelParemters() {
		
	}
}