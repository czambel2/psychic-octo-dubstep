<?php

class RaceController extends Controller {

	public function index() {
		$db = DB::getInstance();
		$q = $db->query("SELECT
			C.numcourse, C.datecourse, C.anneecourse, C.nbparticipantstotal, C.distancec1, C.distancec2, C.distancec3
		FROM
			COURSE C
		ORDER BY
			C.numcourse DESC");
		$q->execute();

		$courses = $q->fetchAll();

		$this->render("race.index", array('courses' => $courses));
	}

	public function edit() {
		$form = new RaceForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'race') {
			$form->bind($_POST['data']);
			if($form->isValid()) {

			}
		}

		$this->render('race.edit', array('form' => $form));
	}

	public function add() {

	}
}