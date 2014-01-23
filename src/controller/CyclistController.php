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

	}

	public function add() {
		$form = new CyclistForm();

		if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('form', $_POST) and $_POST['form'] = 'cyclist') {
			$form->bind($_POST['data']);
			if($form->isValid()) {
				// TODO : add business logic to insert cyclist
			}
		}

		$this->render('cyclist.add', array('form' => $form));
	}
}