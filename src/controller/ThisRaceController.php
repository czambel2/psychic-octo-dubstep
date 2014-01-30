<?php

class ThisRaceController extends Controller {

	public function status() {

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