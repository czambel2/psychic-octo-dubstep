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
		$db = DB::getInstance();

		if(array_key_exists('id', $_GET) and $_GET['id']) {
			$q = $db->prepare('SELECT c.numcourse, c.datecourse, c.distancec1, c.distancec2, c.distancec3 FROM course c WHERE c.numcourse = :numcourse');
			$q->bindValue('numcourse', (int) $_GET['id']);
			$q->execute();

			if(!$race = $q->fetch()) {
				throw new Http404Exception('Impossible de trouver la course n<sup>o</sup> ' . (int) $_GET['id'] . '.');
			}
		} else {
			throw new Http404Exception('Aucune course n\'est spécifiée.');
		}

		$form->bindDatabase(array(
			'date' => new DateTime($race['datecourse']),
			'circuit1' => $race['distancec1'],
			'circuit2' => $race['distancec2'],
			'circuit3' => $race['distancec3'],
		));

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'race') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				$raceNumber = (int) $_GET['id'];

				$q = $db->prepare('UPDATE course SET datecourse = :date, anneecourse = :year, distancec1 = :circuit1,
					distancec2 = :circuit2, distancec3 = :circuit3 WHERE numcourse = :raceNumber');

				$q->bindValue('date', $form->getData('date')->format('Y-m-d H:i:s'));
				$q->bindValue('year', $form->getData('date')->format('Y'));
				$q->bindValue('circuit1', $form->getData('circuit1'));
				$q->bindValue('circuit2', $form->getData('circuit2'));
				$q->bindValue('circuit3', $form->getData('circuit3'));
				$q->bindValue('raceNumber', $raceNumber);

				$q->execute();

				Session::getInstance()->addFlash(new Flash('La course n<sup>o</sup>' . $raceNumber . ' a bien été modifiée.'));
				Utility::redirectRoute('race.index');
			}
		}

		$this->render('race.edit', array('form' => $form));
	}

	public function add() {

	}
}