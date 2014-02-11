<?php

class ApiController extends Controller {
	public function __construct() {
		Layout::getInstance()->disable();
		header("Content-Type: application/json, charset=windows-1252");
		ini_set('html_errors', false);
	}

	public function editReward() {
		if(!array_key_exists('NbParticipation', $_POST) or !array_key_exists('LibRecompense', $_POST)) {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('res' => 'nok'));
			exit;
		}

		$nbParticipation = $_POST['NbParticipation'];
		$libRecompense = $_POST['LibRecompense'];

		$db = DB::getInstance();
		$q = $db->prepare('UPDATE RECOMPENSE SET LIBRECOMPENSE = :libRecompense WHERE NBPARTICIPATION = :nbParticipation');
		$q->bindValue('nbParticipation', $nbParticipation);
		$q->bindValue('libRecompense', $libRecompense);

		try {
			$q->execute();
			echo json_encode(array('res' => 'ok'));
		} catch(PDOException $ex) {
			header("HTTP/1.1 500 Internal Server Error");
			echo json_encode(array('res' => 'nok'));
		}
	}

	public function autocompleteCyclists() {
		if(array_key_exists('term', $_GET)) {
			$db = DB::getInstance();

			$_GET['term'] = utf8_decode($_GET['term']);

			$sql = "SELECT TOP 10 c.numcyc, c.nom, c.prenom FROM cycliste c ";

			if(array_key_exists('filter', $_GET)) {
				if($_GET['filter'] == 'departure') {
					$sql .= "LEFT JOIN participer p ON (p.numcyc = c.numcyc AND p.numcourse = :raceNumber) WHERE p.numcyc IS NULL AND ( ";
				} elseif($_GET['filter'] == 'arrival') {
					$sql .= "INNER JOIN participer p ON (p.numcyc = c.numcyc AND p.numcourse = :raceNumber) WHERE p.harrivee IS NULL AND ( ";
				} else {
					$sql .= "WHERE (";
				}
			} else {
				$sql .= "WHERE (";
			}

			$terms = explode(' ', $_GET['term']);
			foreach($terms as $nb => $term) {
				if($term != reset($terms)) {
					$sql .= "OR ";
				}

				if(ctype_digit($term)) {
					// Un nombre a été entré
					$sql .= "c.numcyc = :numTerm${nb} ";
				} else {
					// Du texte a été entré, on cherche sur tous les champs
					$sql .= "c.nom LIKE :searchTerm${nb} ";
					$sql .= "OR c.prenom LIKE :searchTermX${nb} ";
				}
			}

			$sql .= ')';

			$q = $db->prepare($sql);

			foreach($terms as $nb => $term) {
				if(ctype_digit($term)) {
					// Un nombre a été entré
					$q->bindValue('numTerm' . $nb, $term, PDO::PARAM_INT);
				} else {
					// Du texte a été entré, on cherche sur tous les champs
					$q->bindValue('searchTerm' . $nb, $term . '%');
					$q->bindValue('searchTermX' . $nb, $term . '%');
				}
			}

			if(array_key_exists('filter', $_GET)) {
				if($_GET['filter'] == 'departure' or $_GET['filter'] == 'arrival') {
					$q->bindValue('raceNumber', $this->getLastRaceNumber());
				}
			}

			$q->execute();

			$results = $q->fetchAll();

			$cyclistes = array();
			foreach ($results as $cycliste) {
				$fullName = utf8_encode($cycliste["nom"] . " " . $cycliste["prenom"] . " (" . $cycliste["numcyc"] . ")");
				$cyclistes[] = $fullName;
			}

			echo json_encode($cyclistes);
		} else {
			echo json_encode(array());
		}
	}

	public function cyclistDetails() {
		if(array_key_exists('cyclistId', $_GET)) {
			$db = DB::getInstance();
			$q = $db->prepare('SELECT
					c.numcyc, c.polit, c.nom, c.prenom, c.date_n, c.email, c.adresse, c.cod_post, c.ville, c.nbcourses, c.km, r.librecompense
				FROM
					cycliste c
				LEFT JOIN
					recompense r ON r.nbparticipation = c.nbcourses
				WHERE
					c.numcyc = :cyclistId'
			);
			$q->bindValue('cyclistId', $_GET['cyclistId']);
			$q->execute();

			if($cyclist = $q->fetch()) {
				$data = array(
					'cyclistId' => $cyclist['numcyc'],
					'title' => $cyclist['polit'],
					'lastName' => $cyclist['nom'],
					'firstName' => $cyclist['prenom'],
					'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', $cyclist['date_n'])->format('d/m/Y'),
					'email' => $cyclist['email'],
					'address' => $cyclist['adresse'],
					'zipcode' => $cyclist['cod_post'],
					'city' => $cyclist['ville'],
					'nbRaces' => $cyclist['nbcourses'],
					'rewardName' => $cyclist['librecompense'],
					'totalDistance' => $cyclist['km'],
				);

				$data2 = array('rewards' => null);
				$q = $db->prepare('SELECT r.nbparticipation, r.librecompense FROM recompense r WHERE r.nbparticipation <= :nbTotalRaces');
				$q->bindValue('nbTotalRaces', $cyclist['nbcourses']);
				$q->execute();
				$rewards = $q->fetchAll();
				foreach($rewards as $reward) {
					if(reset($rewards) != $reward) {
						$data2['rewards'] .= ', ';
					}
					$data2['rewards'] .= $reward['librecompense'];
				}

				echo json_encode(array_merge($data, $data2));
			} else {
				header("HTTP/1.1 404 Not Found");
				echo json_encode(array());
			}
		} else {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('res' => 'nok'));
		}
	}

	public function cyclistDetailsForRace() {
		if(array_key_exists('cyclistId', $_GET) and array_key_exists('raceNumber', $_GET)) {
			$raceNumber = $_GET['raceNumber'];

			$db = DB::getInstance();
			$q = $db->prepare('SELECT
				c.numcyc, c.polit, c.nom, c.prenom, c.date_n, c.email, c.adresse, c.cod_post, c.ville, c.nbcourses, c.km, r.librecompense, p.numcircuit
				FROM
					(cycliste c
				LEFT JOIN
					recompense r ON r.nbparticipation = c.nbcourses)
				LEFT JOIN
					participer p ON p.numcyc = c.numcyc
				WHERE
					c.numcyc = :cyclistId
				AND
					p.numcourse = :raceNumber'
			);

			$q->bindValue('raceNumber', $raceNumber);
			$q->bindValue('cyclistId', $_GET['cyclistId']);
			$q->execute();

			if($cyclist = $q->fetch()) {
				$data = array(
					'cyclistId' => $cyclist['numcyc'],
					'title' => $cyclist['polit'],
					'lastName' => $cyclist['nom'],
					'firstName' => $cyclist['prenom'],
					'birthDate' => DateTime::createFromFormat('Y-m-d H:i:s', $cyclist['date_n'])->format('d/m/Y'),
					'email' => $cyclist['email'],
					'address' => $cyclist['adresse'],
					'zipcode' => $cyclist['cod_post'],
					'city' => $cyclist['ville'],
					'nbRaces' => $cyclist['nbcourses'],
					'rewardName' => $cyclist['librecompense'],
					'circuitNumber' => $cyclist['numcircuit'],
					'totalDistance' => $cyclist['km'],
				);

				$circuit = null;
				switch($data['circuitNumber']) {
					case 1: $circuit = 1; break;
					case 2: $circuit = 2; break;
					case 3: $circuit = 3; break;
					default: break;
				}

				$data2 = array();
				if($circuit) {
					$qu = $db->prepare('SELECT
						c.distancec' . $circuit . ' as distance FROM course c WHERE c.numcourse = :raceNumber');
					$qu->bindValue('raceNumber', $raceNumber);
					$qu->execute();

					if($details = $qu->fetch()) {
						$data2 = array(
							'distance' => $details['distance']
						);
					}
				}

				echo json_encode(array_merge($data, $data2));
			} else {
				header("HTTP/1.1 404 Not Found");
				echo json_encode(array());
			}
		} else {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array('res' => 'nok'));
		}
	}

	protected function createListCyclistQuery(DB $db, $type) {

		// Filtrage
		$filteringCriteria = NULL;

		if(array_key_exists('sSearch', $_GET)) {
			$searchTerms = explode(' ', $_GET['sSearch']);
			foreach($searchTerms as $nb => $search) {
				if(reset($searchTerms) != $search) {
					$filteringCriteria .= 'AND ';
				}

				$filteringCriteria .= '(';

				if(ctype_digit($_GET['sSearch'])) {
					$filteringCriteria .= 'c.numcyc = :sSearchInt' . $nb . ' ';
				} else {
					$filteringCriteria .= 'c.nom LIKE :sSearchLike' . $nb . '_1 OR ' .
						'c.prenom LIKE :sSearchLike' . $nb . '_2 OR ' .
						'c.adresse LIKE :sSearchLike' . $nb . '_3 OR ' .
						'c.ville LIKE :sSearchLike' . $nb . '_4 ';
				}

				$filteringCriteria .= ')';
			}
		}

		$orderCriteria = null;
		$allowedSortColumns = array('numcyc', 'nom', 'prenom', 'adresse', 'ville');
		if(array_key_exists('iSortCol_0', $_GET) and array_key_exists($_GET['iSortCol_0'], $allowedSortColumns)) {
			$orderCriteria .= 'c.' . $allowedSortColumns[$_GET['iSortCol_0']] . ' ';

			if(array_key_exists('sSortDir_0', $_GET) and $_GET['sSortDir_0'] == 'desc') {
				$orderCriteria .= 'DESC';
			} else {
				$orderCriteria .= 'ASC';
			}
		}

		$sql = ' FROM cycliste c ';

		if($filteringCriteria) {
			$sql .= 'WHERE ' . $filteringCriteria . ' ';
		}

		if($orderCriteria and $type == 'top') {
			$sql .= 'ORDER BY ' . $orderCriteria . ' ';
		}

		if($type == 'count') {
			$q = $db->prepare('SELECT COUNT(*) AS nb ' . $sql);
		} else {

			if(array_key_exists('iDisplayLength', $_GET) and ctype_digit($_GET['iDisplayLength'])) {
				$topNb = (int) $_GET['iDisplayLength'];
			} else {
				$topNb = 20;
			}

			if(array_key_exists('iDisplayStart', $_GET) and ctype_digit($_GET['iDisplayStart'])) {
				$topNb += (int) $_GET['iDisplayStart'];
			}

			$q = $db->prepare('SELECT DISTINCT TOP ' . $topNb . ' c.numcyc, c.nom, c.prenom, c.adresse, c.ville ' . $sql);
		}

		if($filteringCriteria) {
			if(array_key_exists('sSearch', $_GET)) {
				foreach(explode(' ', $_GET['sSearch']) as $nb => $search) {
					if(ctype_digit($search)) {
						$q->bindValue('sSearchInt' . $nb, $search, PDO::PARAM_INT);
					} else {
						$search = (iconv('UTF-8', 'ASCII//TRANSLIT', $search));
						$search = preg_replace('#[^-\w]+#', '', $search);
						$q->bindValue('sSearchLike' . $nb . '_1', '%' . $search . '%');
						$q->bindValue('sSearchLike' . $nb . '_2', '%' . $search . '%');
						$q->bindValue('sSearchLike' . $nb . '_3', '%' . $search . '%');
						$q->bindValue('sSearchLike' . $nb . '_4', '%' . $search . '%');
					}
				}
			}
		}

		return $q;
	}

	public function listCyclists() {

		if(!array_key_exists('sEcho', $_GET)) {
			header("HTTP/1.1 400 Bad Request");
			echo json_encode(array(
				'res' => 'nok',
			));
			exit;
		}

		$db = DB::getInstance();

		$q = $db->query('SELECT COUNT(*) AS nb FROM cycliste c');
		$q->execute();
		$data = $q->fetch();
		$nbTotal = $data['nb'];

		$q = $this->createListCyclistQuery($db, 'count');
		$q->execute();
		$data = $q->fetch();
		$nbFiltered = $data['nb'];

		$q = $this->createListCyclistQuery($db, 'top');
		$q->execute();

		$queryCyclists = $q->fetchAll();

		if(array_key_exists('iDisplayStart', $_GET) and ctype_digit($_GET['iDisplayStart'])) {
			$offset = $_GET['iDisplayStart'];
		}

		if(array_key_exists('iDisplayLength', $_GET) and ctype_digit($_GET['iDisplayLength'])) {
			$limit = (int) $_GET['iDisplayLength'];
		}

		array_splice($queryCyclists, 0, $offset);
		array_splice($queryCyclists, $limit);

		$reply = array();

		$cyclists = array();
		foreach($queryCyclists as $cyclist) {
			$cyclists[] = array(
				utf8_encode($cyclist['numcyc']),
				utf8_encode($cyclist['nom']),
				utf8_encode($cyclist['prenom']),
				utf8_encode($cyclist['adresse']),
				utf8_encode($cyclist['ville']),
				'<a class="view-button" title="Afficher" href="' . url('cyclist.search', array("id" => $cyclist["numcyc"])) . '">Afficher</a>' .
				'<a class="edit-button" title="Modifier" href="' . url('cyclist.edit', array("id" => $cyclist["numcyc"])) . '">Modifier</a>'
			);
		}

		$reply['sEcho'] = $_GET['sEcho'];
		$reply['iTotalRecords'] = $nbTotal;
		$reply['iTotalDisplayRecords'] = $nbFiltered;
		$reply['aaData'] = $cyclists;

		echo json_encode($reply);
	}
}