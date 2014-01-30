<?php

class ThisRaceController extends Controller {

	public function status() {

	}

	public function add() {

	}

	public function start() {

	}

	public function departure() {

	}

	public function arrival() {

	}

	public function close() {

	}

	public  function stop() {

	}

	public function rewards() {
		$db = DB::getInstance();
		$q = $db->query("SELECT
			R.nbparticipation, R.librecompense
		FROM
			RECOMPENSE R
		ORDER BY
			R.NbParticipation ASC");
		$q->execute();

		$rewards = $q->fetchAll();

		$this->render("thisRace.rewards", array('rewards' => $rewards));
	}
}