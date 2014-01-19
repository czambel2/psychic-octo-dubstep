<?php

class LoginController extends Controller {
	public function showForm() {
		if(Session::getInstance()->is('logged')) {
			// Si l'utilisateur est d�j� connect�, on le redirige vers la page d'accueil
			Session::getInstance()->add('flash', new Flash('Vous �tes d�j� connect�.'));
			Utility::redirect(Router::generateUrl('home.index'));
		}

		$form = new LoginForm();

		if($_SERVER['REQUEST_METHOD'] == "POST" and array_key_exists('form', $_POST) and $_POST['form'] = 'login') {
			$form->bind($_POST['data']);
			if($form->isValid()) {

				// On connecte l'utilisateur
				Session::getInstance()->set('logged', true);

				// On le redirige vers la page qu'il avait demand�e
				Utility::redirect($_SERVER['REQUEST_URI']);
			}
		}

		// On d�sactive le menu
		Layout::getInstance()->showMenu(false);

		$this->render('login.showForm', array(
			'form' => $form,
		));
	}

	public function logout() {
		if(Session::getInstance()->is('logged')) {
			Session::getInstance()->set('logged', false);
			Session::getInstance()->add('flash', new Flash('Vous avez �t� d�connect� avec succ�s.', Flash::FLASH_SUCCESS));
		}

		Utility::redirect(Router::generateUrl('home.index'));
	}
}