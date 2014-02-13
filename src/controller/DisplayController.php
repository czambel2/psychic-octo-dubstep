<?php

class DisplayController extends Controller {

	public function diploma() {
		$form = new PrintDiplomaForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] == 'printDiploma') {
			$form->bind($_POST['data']);
			if($form->isValid()) {

				$cyclistId = null;

				if($form->getData('action') == 'printOne') {
					if(ctype_digit($form->getData('cyclistName')) and ((int) $form->getData('cyclistName')) > 0) {
						$cyclistId = (int) $form->getData('cyclistName');
					} else {
						if(!preg_match("/^.+ \((\d+)\)$/", $form->getData('cyclistName'), $data)) {
							$form->addError('cyclistName', 'Ce champ est invalide.');
						} else {
							$cyclistId = $data[1];
						}
					}
				}

				if($cyclistId) {
					Utility::redirectRoute('display.diplomaPdf', array('id' => $cyclistId));
				} else {
					Utility::redirectRoute('display.diplomaPdf', array('type' => $form->getData('action')));
				}
			}
		}

		$this->render('display.diploma', array(
				'form' => $form,
			));
	}

	public function diplomaPdf() {
		Layout::getInstance()->disable();

		header("Content-Type: application/pdf");

		if(Config::get('download.pdf')) {
			header("Content-Disposition: attachment; filename=diplome.pdf");
		}

		$diploma = new Diploma();

		$db = DB::getInstance();

		if(array_key_exists('id', $_GET) and ctype_digit($_GET['id'])) {
			$q = $db->prepare('SELECT
				c.polit, c.nom, c.prenom, o.datecourse, p.numcircuit, o.distancec1, o.distancec2, o.distancec3
			FROM
				(participer p
			INNER JOIN
				course o ON o.numcourse = p.numcourse)
			INNER JOIN
				cycliste c ON c.numcyc = p.numcyc
			WHERE
				o.numcourse = :raceNumber
				AND c.numcyc = :cyclistId
			ORDER BY
				c.nom, c.prenom');
			$q->bindValue('cyclistId', $_GET['id']);
			$q->bindValue('raceNumber', $this->getLastRaceNumber());
		} elseif(array_key_exists('type', $_GET) and $_GET['type'] == 'printMissing') {
			$q = $db->prepare('SELECT
				c.polit, c.nom, c.prenom, o.datecourse, p.numcircuit, o.distancec1, o.distancec2, o.distancec3
			FROM
				(participer p
			INNER JOIN
				course o ON o.numcourse = p.numcourse)
			INNER JOIN
				cycliste c ON c.numcyc = p.numcyc
			WHERE
				o.numcourse = :raceNumber
				AND p.hdepart IS NOT NULL
				AND p.harrivee IS NULL
			ORDER BY
				c.nom, c.prenom');
			$q->bindValue('raceNumber', $this->getLastRaceNumber());
		} else {
			$q = $db->prepare('SELECT
				c.polit, c.nom, c.prenom, o.datecourse, p.numcircuit, o.distancec1, o.distancec2, o.distancec3
			FROM
				(participer p
			INNER JOIN
				course o ON o.numcourse = p.numcourse)
			INNER JOIN
				cycliste c ON c.numcyc = p.numcyc
			WHERE
				o.numcourse = :raceNumber
			ORDER BY
				c.nom, c.prenom');
			$q->bindValue('raceNumber', $this->getLastRaceNumber());
		}

		$q->execute();

		foreach($q->fetchAll() as $cyclist) {
			$diploma->addCyclist(
				$cyclist['polit'] == 'M' ? 'M' : 'F',
				$cyclist['polit'] . ' ' . $cyclist['nom'] . ' ' . $cyclist['prenom'],
				DateTime::createFromFormat('Y-m-d H:i:s', $cyclist['datecourse']),
				$cyclist['numcircuit'],
				$cyclist['distancec' . $cyclist['numcircuit']]
			);
		}

		echo $diploma->get();
	}

	public function cyclists() {
		$db = DB::getInstance();
		$q = $db->query("SELECT c.numcyc, c.nom, c.prenom, c.adresse, c.ville FROM CYCLISTE c order by c.numcyc");
		$q->execute();

		$cyclistes = $q->fetchAll();

		$this->render("display.cyclists", array('cyclistes' => $cyclistes));
	}

	public function races() {
		$db = DB::getInstance();
		$q = $db->query("SELECT
			c.numcourse, c.datecourse, c.anneecourse, c.nbparticipantstotal, c.distancec1, c.distancec2, c.distancec3
		FROM
			COURSE c
		ORDER BY
			c.numcourse DESC");
		$q->execute();

		$races = $q->fetchAll();

		$this->render("display.races", array('races' => $races));
	}

	public function label() {

	}
}