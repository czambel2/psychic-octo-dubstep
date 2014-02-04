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
			$raceNumber = (int) $_GET['id'];

			$q = $db->prepare('SELECT c.numcourse, c.datecourse, c.distancec1, c.distancec2, c.distancec3,
				c.nbparticipantsc1, c.nbretourc1, c.nbparticipantsc2, c.nbretourc2, c.nbparticipantsc3, c.nbretourc3,
				c.nbparticipantstotal, c.nbretourtotal
				FROM course c WHERE c.numcourse = :numcourse');
			$q->bindValue('numcourse', $raceNumber);
			$q->execute();

			if(!$race = $q->fetch()) {
				throw new Http404Exception('Impossible de trouver la course n<sup>o</sup> ' . (int) $_GET['id'] . '.');
			}
		} else {
			Session::getInstance()->addFlash(new Flash('Veuillez sélectionner la course que vous souhaitez modifier.'));
			Utility::redirectRoute('race.index');
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
				// On vérifie si une course n'existe pas déjà cette année
				$q = $db->prepare('SELECT COUNT(*) AS nb FROM course WHERE anneecourse = :year AND NOT numcourse = :raceNumber');
				$q->bindValue('year', $form->getData('date')->format('Y'));
				$q->bindValue('raceNumber', $raceNumber);
				$q->execute();
				$data = $q->fetch();

				if($data['nb'] > 0) {
					$form->addError('date', 'Une course existe déjà pour l\'année ' . $form->getData('date')->format('Y') . '.' );
				} else {
					$q = $db->prepare('UPDATE course SET datecourse = :date, anneecourse = :year, distancec1 = :circuit1,
						distancec2 = :circuit2, distancec3 = :circuit3 WHERE numcourse = :raceNumber');

					$q->bindValue('date', $form->getData('date')->format('d/m/Y'));
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
		}

		$this->render('race.edit', array(
			'form' => $form,
			'raceNumber' => $raceNumber,
			'participants' => array(1 => $race['nbparticipantsc1'], $race['nbparticipantsc2'], $race['nbparticipantsc3']),
			'arrivals' => array(1 => $race['nbretourc1'], $race['nbretourc2'], $race['nbretourc3']),
			'totalParticipants' => $race['nbparticipantstotal'],
			'totalArrivals' => $race['nbretourtotal'],
		));
	}

	public function add() {
		$form = new RaceForm();
		$db = DB::getInstance();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'race') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				// On vérifie si une course n'existe pas déjà cette année
				$q = $db->prepare('SELECT COUNT(*) AS nb FROM course WHERE anneecourse = :year');
				$q->bindValue('year', $form->getData('date')->format('Y'));
				$q->execute();
				$data = $q->fetch();

				if($data['nb'] > 0) {
					$form->addError('date', 'Une course existe déjà pour l\'année ' . $form->getData('date')->format('Y') . '.' );
				} else {
					$q = $db->query('SELECT MAX(numcourse) AS nb FROM course');
					$q->execute();
					$data = $q->fetch();
					$raceNumber = $data['nb'] + 1;

					$q = $db->prepare('INSERT INTO COURSE(Numcourse, DateCourse, AnneeCourse, NbParticipantsTotal,
						NbParticipantsC1, NbParticipantsC2, NbParticipantsC3, NbRetourTotal,
						NbRetourC1, NbRetourC2, NbRetourC3, DistanceC1, DistanceC2, DistanceC3,
						Decompte, Nb3Participations, Nb6Participations, Nb9Participations, Nb12Participations,
						Nb15Participations, Nb18Participations, Nb21Participations, Nb24Participations,
						Nb27Participations, Nb30Participations) VALUES(:raceNumber, :date, :year, 0,
						0, 0, 0, 0, 0, 0, 0, :circuit1, :circuit2, :circuit3, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)');

					$q->bindValue('raceNumber', $raceNumber);
					$q->bindValue('date', $form->getData('date')->format('d/m/Y'));
					$q->bindValue('year', $form->getData('date')->format('Y'));
					$q->bindValue('circuit1', $form->getData('circuit1'));
					$q->bindValue('circuit2', $form->getData('circuit2'));
					$q->bindValue('circuit3', $form->getData('circuit3'));

					$q->execute();

					Session::getInstance()->addFlash(new Flash('La course n<sup>o</sup>' . $raceNumber . ' a bien été créée.'));
					Utility::redirectRoute('race.index');
				}
			}
		}

		$this->render('race.add', array(
			'form' => $form,
		));
	}
}