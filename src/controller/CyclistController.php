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

	}
}