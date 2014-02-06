<?php

class CyclistController extends Controller {

	public function index() {
		$db = DB::getInstance();
		$q = $db->prepare('SELECT
			c.numcyc, c.nom, c.prenom, c.adresse, c.ville
		FROM
			CYCLISTE c');
		$q->execute();

		$cyclists = $q->fetchAll();

		$this->render('cyclist.index', array('cyclists' => $cyclists));
	}

	public function search() {
		//$db = DB::getInstance();

		$form = new SearchCyclistForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'searchCyclist') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				if(!preg_match("/^.+ \((\d+)\)$/", $form->getData('cyclistName'), $data)) {
					$form->addError('cyclistName', 'Ce champ est invalide.');
				}
			}
		}
		$this->render('cyclist.search', array(
			'form' => $form
		));
	}

	public function add() {
		$form = new CyclistForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'cyclist') {
			$form->bind($_POST['data']);
			if($form->isValid()) {

				$db = DB::getInstance();

				// Récupération de l'ID du dernier cycliste
				$q = $db->query('SELECT TOP 1 numcyc FROM cycliste ORDER BY numcyc DESC');
				$q->execute();
				$result = $q->fetch();
				$lastId = $result['numcyc'];

				$q = $db->prepare('INSERT INTO CYCLISTE(NUMCYC, NOM, PRENOM, POLIT, CAT, ASCAP, SEXE, ADR_USI, USINE, DATE_N, PARTIC, ADRESSE, VILLE, COD_POST, DERNUMCOURSE, DERANCOURSE, DEPART, RETOUR, KM, NBCOURSES, validation)
				VALUES(:numcyc, :lastName, :firstName, :title, :category, :ascap, :gender, :factoryAddress, :factory, :birthDate, 0, :address, :city, :zipcode, 0, 0, NULL, NULL, 0, 0, 0)');

				$q->bindValue('numcyc', $lastId + 1);
				$q->bindValue('lastName', $form->getData('lastName'));
				$q->bindValue('firstName', $form->getData('firstName'));
				$q->bindValue('title', $form->getData('title'));
				$q->bindValue('category', $form->getData('category'));
				$q->bindValue('ascap', $form->getData('ascap'));
				$q->bindValue('gender', $form->getData('title') == 'M' ? 'M' : 'F');
				$q->bindValue('factoryAddress', $form->getData('factoryAddress'));
				$q->bindValue('factory', $form->getData('factory'));
				$q->bindValue('birthDate', $form->getData('birthDate')->format('d/m/Y'));
				$q->bindValue('address', $form->getData('address'));
				$q->bindValue('city', $form->getData('city'));
				$q->bindValue('zipcode', $form->getData('zipcode'));

				$q->execute();

				$cyclistName = htmlspecialchars($form->getData('firstName') . ' ' . $form->getData('lastName'));

				Session::getInstance()->addFlash(new Flash('Cycliste ' . $cyclistName . ' ajouté.', Flash::FLASH_SUCCESS));
				Utility::redirectRoute('cyclist.index');
			}
		}

		$this->render('cyclist.add', array('form' => $form));
	}

	public function edit() {
		$form = new CyclistForm();
		$db = DB::getInstance();

		if(array_key_exists('id', $_GET) and $_GET['id']) {
			$q = $db->prepare('SELECT
				c.numcyc, c.nom, c.prenom, c.polit, c.cat, c.ascap, c.adr_usi, c.usine, c.date_n, c.adresse, c.ville, c.cod_post
			FROM
				cycliste c
			WHERE
				c.numcyc = :numcyc');
			$q->bindValue('numcyc', (int) $_GET['id']);
			$q->execute();

			if(!$cyclist = $q->fetch()) {
				throw new Http404Exception('Impossible de trouver le cycliste n<sup>o</sup> ' . (int) $_GET['id'] . '.');
			}
		} else {
			throw new Http404Exception('Aucun cycliste n\'est spécifié.');
		}

		$form->bindDatabase(array(
			'numcyc' => $cyclist['numcyc'],
			'lastName' => $cyclist['nom'],
			'firstName' => $cyclist['prenom'],
			'title' => $cyclist['polit'],
			'category' => $cyclist['cat'],
			'ascap' => $cyclist['ascap'],
			'factoryAddress' => $cyclist['adr_usi'],
			'factory' => $cyclist['usine'],
			'birthDate' => new DateTime($cyclist['date_n']),
			'address' => $cyclist['adresse'],
			'city' => $cyclist['ville'],
			'zipcode' => $cyclist['cod_post']
		));

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'cyclist') {
			$form->bind($_POST['data']);
			if($form->isValid()) {

				// Récupération de l'ID du cycliste

				$q = $db->prepare('UPDATE CYCLISTE
				SET
					NOM = :lastName,
					PRENOM = :firstName,
					POLIT = :title,
					CAT = :category,
					ASCAP = :ascap,
					SEXE = :gender,
					ADR_USI = :factoryAddress,
					USINE = :factory,
					DATE_N = :birthDate,
					ADRESSE = :address,
					VILLE = :city,
					COD_POST = :zipcode
				WHERE
					NUMCYC = :numcyc');

				$q->bindValue('numcyc', (int) $_GET['id']);
				$q->bindValue('lastName', $form->getData('lastName'));
				$q->bindValue('firstName', $form->getData('firstName'));
				$q->bindValue('title', $form->getData('title'));
				$q->bindValue('category', $form->getData('category'));
				$q->bindValue('ascap', $form->getData('ascap'));
				$q->bindValue('gender', $form->getData('title') == 'M' ? 'M' : 'F');
				$q->bindValue('factoryAddress', $form->getData('factoryAddress'));
				$q->bindValue('factory', $form->getData('factory'));
				$q->bindValue('birthDate', $form->getData('birthDate')->format('d/m/Y'));
				$q->bindValue('address', $form->getData('address'));
				$q->bindValue('city', $form->getData('city'));
				$q->bindValue('zipcode', $form->getData('zipcode'));

				$q->execute();

				$cyclistName = htmlspecialchars($form->getData('firstName') . ' ' . $form->getData('lastName'));

				Session::getInstance()->addFlash(new Flash('Cycliste ' . $cyclistName . ' modifié.', Flash::FLASH_SUCCESS));

				if(array_key_exists('returnto', $_GET)) {
					Utility::redirect($_GET['returnto']);
				} else {
					Utility::redirectRoute('cyclist.index');
				}
			}
		}


		$this->render('cyclist.edit', array('form' => $form));
	}
}