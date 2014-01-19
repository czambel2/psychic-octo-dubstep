<?php

class DisplayController extends Controller {

	public function cyclistes() {
		$db = DB::getInstance();
		$q = $db->query("SELECT c.numcyc, c.nom, c.prenom, c.adresse, c.ville FROM CYCLISTE c order by c.numcyc");
		$q->execute();

		$cyclistes = $q->fetchAll();

		$this->render("display.cyclistes", array('cyclistes' => $cyclistes));
	}
}