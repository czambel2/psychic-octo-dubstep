<?php

class ThisRaceController extends Controller {

	public function status() {
		$db = DB::getInstance();

		$raceNumber = $this->getLastRaceNumber();

		// On regarde l'état de la course
		$q = $db->prepare('SELECT decompte, distancec1, distancec2, distancec3, nb3participations, nb6participations,
			nb9participations, nb12participations, nb15participations, nb18participations, nb21participations,
			nb24participations, nb27participations, nb30participations FROM course WHERE numcourse = :numcourse');
		$q->bindValue('numcourse', $raceNumber);
		$q->execute();

		$race = $q->fetch();

		if(!$race) {
			throw new Http404Exception('Impossible de trouver de course dans la base !');
		}

		if($race['decompte'] == 'Vrai') {
			$raceStatus = 'started';
		} elseif($race['decompte'] == '') {
			$raceStatus = 'notStarted';
		} else {
			$raceStatus = 'ended';
		}

		// On récupère les distances
		$distances = array(1 => $race['distancec1'], 2 => $race['distancec2'], 3 => $race['distancec3']);

		// On récupère le nombre de personnes parties
		$departures = array();
		$totalDepartures = 0;

		$q = $db->prepare('SELECT COUNT(*) AS nb FROM participer WHERE numcircuit = :numcircuit AND numcourse = :numcourse AND hdepart IS NOT NULL');
		for($circuit = 1; $circuit <= 3; $circuit++) {
			$q->bindValue('numcircuit', $circuit);
			$q->bindValue('numcourse', $raceNumber);
			$q->execute();
			$data = $q->fetch();
			$departures[$circuit] = $data['nb'];
			$totalDepartures += $data['nb'];
		}

		// On récupère le nombre de personnes arrivées
		$arrivals = array();
		$totalArrivals = 0;

		$q = $db->prepare('SELECT COUNT(*) AS nb FROM participer WHERE numcircuit = :numcircuit AND numcourse = :numcourse AND harrivee IS NOT NULL');
		for($circuit = 1; $circuit <= 3; $circuit++) {
			$q->bindValue('numcircuit', $circuit);
			$q->bindValue('numcourse', $raceNumber);
			$q->execute();
			$data = $q->fetch();
			$arrivals[$circuit] = $data['nb'];
			$totalArrivals += $data['nb'];
		}

		// On récupère le nombre de personnes concernées par les récompenses
		$participations = array();
		for($i = 3; $i <= 30; $i += 3) {
			$participations[$i] = $race['nb' . $i . 'participations'];
		}

		// On récupère la liste des récompenses
		$q = $db->query('SELECT nbparticipation, librecompense FROM recompense ORDER BY nbparticipation ASC');
		$q->execute();

		$rewards = array();
		foreach($q->fetchAll() as $reward) {
			$rewards[$reward['nbparticipation']] = $reward['librecompense'];
		}

		$this->render('thisRace.status', array(
			'raceStatus' => $raceStatus,
			'distances' => $distances,
			'departures' => $departures,
			'totalDepartures' => $totalDepartures,
			'arrivals' => $arrivals,
			'totalArrivals' => $totalArrivals,
			'participations' => $participations,
			'rewards' => $rewards,
		));
	}

	public function start() {
		$db = DB::getInstance();

		$today = new DateTime();

		$q = $db->prepare('SELECT c.numcourse, c.decompte, c.datecourse, c.anneecourse FROM course c WHERE c.datecourse = :date');
		$q->bindValue('date', $today->format('d/m/Y'));
		$q->execute();

		$race = $q->fetch();

		if($race) {
			if($race['decompte'] == 'Vrai') {
				$raceStatus = 'started';
			} elseif($race['decompte'] == '') {
				$raceStatus = 'notStarted';
			} else {
				$raceStatus = 'ended';
			}
		} else {
			$raceStatus = 'inexistant';
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'startRace') {
			if($raceStatus != 'notStarted') {
				Session::getInstance()->addFlash(
					new Flash('La course est déjà commencée.', Flash::FLASH_ALERT)
				);
			} else {
				$q = $db->prepare("UPDATE course SET decompte = 'Vrai' WHERE numcourse = :numcourse");
				$q->bindValue('numcourse', $race['numcourse']);
				$q->execute();

				Session::getInstance()->addFlash(new Flash('La course est démarrée.'));
				Utility::redirectRoute('thisRace.status');
			}
		}

		$this->render('thisRace.start', array(
			'race' => $race,
			'raceStatus' => $raceStatus,
		));
	}

	public function enterDeparture() {
		$db = DB::getInstance();

		$q = $db->prepare('SELECT numcourse, datecourse, decompte, distancec1, distancec2, distancec3 FROM course
			WHERE numcourse = :raceNumber');
		$q->bindValue('raceNumber', $this->getLastRaceNumber());
		$q->execute();

		$race = $q->fetch();

		$raceNumber = $race['numcourse'];

		if(!$race) {
			Session::getInstance()->addFlash(new Flash('La course n\'a pas été trouvée.', Flash::FLASH_ALERT));
			Utility::redirectRoute('race.index');
		} elseif($race['decompte'] == '') {
			Session::getInstance()->addFlash(new Flash('La course n\'a pas encore démarré.', Flash::FLASH_ALERT));
			Utility::redirectRoute('race.index');
		} elseif($race['decompte'] == 'Faux') {
			Session::getInstance()->addFlash(new Flash('La course est terminée. Créez une nouvelle course pour saisir des départs.', Flash::FLASH_ALERT));
			Utility::redirectRoute('race.index');
		}

		$form = new DepartureForm();
		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'enterDeparture') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				$cyclistId = null;

				if(ctype_digit($form->getData('cyclistName')) and ((int) $form->getData('cyclistName')) > 0) {
					$cyclistId = (int) $form->getData('cyclistName');
				} else {
					if(!preg_match("/^.+ \((\d+)\)$/", $form->getData('cyclistName'), $data)) {
						$form->addError('cyclistName', 'Ce champ est invalide.');
					} else {
						$cyclistId = $data[1];
					}
				}

				if($cyclistId) {
					// On vérifie que le cycliste existe
					$q = $db->prepare('SELECT numcyc, nom, prenom, nbcourses FROM cycliste WHERE numcyc = :cyclistId');
					$q->bindValue('cyclistId', $cyclistId);
					$q->execute();
					$cyclist = $q->fetch();

					if(!$cyclist) {
						$form->addError('cyclistName', 'Ce cycliste n\'existe pas.');
					} else {
						// On vérifie si le cycliste n'est pas déjà inscrit dans la course
						$q = $db->prepare('SELECT COUNT(*) AS nb FROM participer WHERE numcourse = :raceNumber AND numcyc = :cyclistId');
						$q->bindValue('raceNumber', $raceNumber);
						$q->bindValue('cyclistId', $cyclistId);
						$q->execute();
						$data = $q->fetch();

						if($data['nb'] > 0) {
							$form->addError('cyclistName', 'Ce cycliste est déjà parti.');
						} else {
							$now = new DateTime();

							// On met à jour le nombre de participants à la course
							$circuitField = 'nbparticipantsc' . ((int) $form->getData('circuit'));
							$nbRacesForCyclist = $cyclist['nbcourses'] + 1;
							if($nbRacesForCyclist % 3 == 0) {
								$queryPart = ", nb${nbRacesForCyclist}participations = nb${nbRacesForCyclist}participations + 1";
							} else {
								$queryPart = null;
							}
							$q = $db->prepare("UPDATE course SET $circuitField = $circuitField + 1, nbparticipantstotal = nbparticipantstotal + 1$queryPart WHERE numcourse = :raceNumber");
							$q->bindValue('raceNumber', $raceNumber);
							$q->execute();

							// On met à jour la table Obtenir
							if($nbRacesForCyclist % 3 == 0) {
								$q = $db->prepare('INSERT INTO obtenir(nbparticipation, numcyc) VALUES(:nbRaces, :cyclistId)');
								$q->bindValue('nbRaces', $nbRacesForCyclist);
								$q->bindValue('cyclistId', $cyclistId);
								$q->execute();
							}

							// On modifie l'heure de départ dans la table cycliste
							/* Utilité ?
							$q = $db->prepare('UPDATE cycliste SET depart = :time WHERE numcyc = :cyclistId');
							$q->bindValue('time', $now->format('H:i:s'));
							$q->bindValue('cyclistId', $cyclistId);
							$q->execute();
							*/

							// On met à jour les infos du cycliste
							$q = $db->prepare('UPDATE cycliste SET nbcourses = nbcourses + 1,
								dernumcourse = :raceNumber WHERE numcyc = :cyclistId');
							$q->bindValue('raceNumber', $raceNumber);
							$q->bindValue('cyclistId', $cyclistId);
							$q->execute();

							// On ajoute la participation
							$q = $db->prepare('INSERT INTO participer(numcourse, numcyc, numcircuit, hdepart, harrivee)
								VALUES(:raceNumber, :cyclistId, :circuit, :time, NULL)');
							$q->bindValue('raceNumber', $raceNumber);
							$q->bindValue('cyclistId', $cyclistId);
							$q->bindValue('circuit', $form->getData('circuit'));
							$q->bindValue('time', $now->format('H:i:s'));
							$q->execute();

							Session::getInstance()->addFlash(new Flash($cyclist['prenom'] . " " . $cyclist['nom'] . " : départ enregistré.", Flash::FLASH_SUCCESS));
							Utility::redirectRoute('thisRace.enterDeparture');
						}
					}
				} else {
					$form->addError('cyclistName', 'Ce champ est invalide.');
				}
			}
		}

		$distances = array();
		for($i = 1; $i <= 3; $i++) {
			$distances[$i] = $race['distancec' . $i];
		}
		$form->setMiscData('distances', $distances);

		$this->render('thisRace.enterDeparture', array(
			'form' => $form,
			'race' => $race,
		));
	}

	public function enterArrival() {

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
			R.nbparticipation ASC");
		$q->execute();

		$rewards = $q->fetchAll();

		$this->render("thisRace.rewards", array('rewards' => $rewards));
	}

	public function addReward() {
		$form = new RewardForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'reward') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				$db = DB::getInstance();

				$q = $db->query('SELECT MAX(NbParticipation) as maxParticipation FROM RECOMPENSE');
				$q->execute();
				$result = $q->fetch();
				$numParticipation = $result['maxParticipation'];

				$q = $db->prepare('INSERT INTO RECOMPENSE(NbParticipation, LIBRECOMPENSE)
				VALUES(:nbParticipation, :libRecompense)');

				$q->bindValue('nbParticipation', $numParticipation + 3);
				$q->bindValue('libRecompense', $form->getData('rewardLabel'));

				$q->execute();

				Session::getInstance()->addFlash(new Flash('Récompense ajoutée.', Flash::FLASH_SUCCESS));
				Utility::redirectRoute('thisRace.rewards');
			}
			var_dump($form);
		}
		$this->render("thisRace.addReward", array('form' => $form));
	}
}