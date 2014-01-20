<?php

class RaceController extends Controller {

	public function display() {
		$db = DB::getInstance();
		$q = $db->query("SELECT
			C.numcourse, C.datecourse, C.anneecourse, C.nbparticipantstotal, C.distancec1, C.distancec2, C.distancec3
		FROM
			COURSE C
		ORDER BY
			C.numcourse DESC");
		$q->execute();

		$courses = $q->fetchAll();

		$this->render("race.display", array('courses' => $courses));
	}

	public function modify() {

	}

	public function add() {

	}
}