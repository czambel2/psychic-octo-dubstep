<?php

class ThisRaceController extends Controller {

	/**
	 * R�cup�re le num�ro de la derni�re course
	 */
	protected function getLastRaceNumber() {
		$db = DB::getInstance();
		$q = $db->query('SELECT MAX(NUMCOURSE) AS nb FROM COURSE');
		$q->execute();
		return $q->fetch()['nb'];
	}

	public function status() {
		$db = DB::getInstance();

		$raceNumber = $this->getLastRaceNumber() - 1;

		// On regarde l'�tat de la course
		$q = $db->prepare('SELECT decompte, distancec1, distancec2, distancec3 FROM course WHERE numcourse = :numcourse');
		$q->bindValue('numcourse', $raceNumber);
		$q->execute();

		$race = $q->fetch();

		if(!$race) {
			throw new Http404Exception('Impossible de trouver de course dans la base !');
		}

		$decompte = $race['decompte'];

		if($decompte == null) {
			$raceStatus = "notyet";
		} elseif($decompte == "Faux") {
			$raceStatus = "ended";
		} else {
			$raceStatus = "ongoing";
		}

		// On r�cup�re les distances
		$distances = array(1 => $race['distancec1'], 2 => $race['distancec2'], 3 => $race['distancec3']);

		// On r�cup�re le nombre de personnes parties
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

		// On r�cup�re le nombre de personnes arriv�es
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

		// On r�cup�re le nombre de personnes concern�es par les r�compenses
		$q = $db->prepare('SELECT
			nb3participations, nb6participations, nb9participations, nb12participations, nb15participations,
			nb18participations, nb21participations, nb24participations, nb27participations, nb30participations
			FROM course WHERE numcourse = :numcourse');
		$q->bindValue('numcourse', $raceNumber);
		$q->execute();
		$data = $q->fetch();

		$participations = array();
		for($i = 3; $i <= 30; $i += 3) {
			$participations[$i] = $data['nb' . $i . 'participations'];
		}

		// On r�cup�re la liste des r�compenses
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
}