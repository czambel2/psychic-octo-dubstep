<?php

class StatisticsController extends Controller {

	public function yearly() {
		$db = DB::getInstance();

		$raceNumber = $this->getLastRaceNumber();
		$q = $db->prepare('SELECT c.distancec1, c.distancec2, c.distancec3
		                   FROM course c
		                   WHERE c.numcourse = :raceNumber');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		$race = $q->fetch();

		$q = $db->query('SELECT COUNT(*) AS nb
		                 FROM cycliste');
		$q->execute();
		$nbTotalCyclists = $q->fetch()['nb'];

		$q = $db->prepare('SELECT COUNT(*) AS nb
		                   FROM participer p
		                   WHERE p.numcourse = :raceNumber');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		$nbDepartures = $q->fetch()['nb'];

		$q = $db->prepare('SELECT COUNT(*) AS nb FROM participer p
		                   WHERE p.harrivee IS NOT NULL
		                   AND p.numcourse = :raceNumber');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		$nbArrivals = $q->fetch()['nb'];

		$nbMissing = $nbDepartures - $nbArrivals;

		$distances = array(1 => $race['distancec1'], $race['distancec2'], $race['distancec3']);

		$nbPerCircuit = array();
		$q = $db->prepare('SELECT p.numcircuit, COUNT(*) AS nb FROM participer p
		                   WHERE p.numcourse = :raceNumber
		                   GROUP BY p.numcircuit
		                   ORDER BY p.numcircuit');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		foreach($q->fetchAll() as $stat) {
			$nbPerCircuit[$stat['numcircuit']] = $stat['nb'];
		}

		$q = $db->prepare('SELECT TOP 1 c.polit, c.nom, c.prenom, c.ville, c.date_n
		                   FROM cycliste c
		                   INNER JOIN participer p ON p.numcyc = c.numcyc
		                   WHERE p.numcourse = :raceNumber
		                   ORDER BY c.date_n ASC');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		$oldestCyclist = $q->fetch();
		$oldestCyclist['date_n'] = DateTime::createFromFormat('Y-m-d H:i:s', $oldestCyclist['date_n']);

		$q = $db->prepare('SELECT TOP 1 c.polit, c.nom, c.prenom, c.ville, c.date_n
		                   FROM cycliste c
		                   INNER JOIN participer p ON p.numcyc = c.numcyc
		                   WHERE p.numcourse = :raceNumber
		                   ORDER BY c.date_n DESC');
		$q->bindValue('raceNumber', $raceNumber);
		$q->execute();
		$youngestCyclist = $q->fetch();
		$youngestCyclist['date_n'] = DateTime::createFromFormat('Y-m-d H:i:s', $youngestCyclist['date_n']);

		$this->render('statistics.yearly', array(
			'race' => $race,
			'nbTotalCyclists' => $nbTotalCyclists,
			'nbDepartures' => $nbDepartures,
			'nbArrivals' => $nbArrivals,
			'nbMissing' => $nbMissing,
			'distances' => $distances,
			'nbPerCircuit' => $nbPerCircuit,
			'oldestCyclist' => $oldestCyclist,
			'youngestCyclist' => $youngestCyclist,
		));
	}

	public function globalSummary($csv = false) {

	}

	public function globalSummaryCsv() {
		$this->globalSummary(true);
	}

	public function simplifiedSummary($csv = false) {

	}

	public function simplifiedSummaryCsv() {
		$this->simplifiedSummary(true);
	}
}