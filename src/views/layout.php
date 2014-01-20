<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="fr"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="fr"><!--<![endif]-->
<head>
	<meta charset="iso-8859-1" />
	<meta name="viewport" content="width=device-width" />
	<title>Lionne</title>

	<link rel="stylesheet" type="text/css" href="<?= basePath() ?>/assets/css/foundation.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= basePath() ?>/assets/css/style.css" />

	<script src="<?= basePath() ?>/assets/js/foundation/modernizr.foundation.js"></script>
	<script src="<?= basePath() ?>/assets/js/foundation/foundation.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="<?= basePath() ?>/assets/js/script.js"></script>
</head>
<body class="special">

	<?php if($showMenu): ?>
		<nav class="top-bar">
			<ul>
				<!-- Title Area -->
				<li class="name">
					<h1>
						<a href="<?= url('home.index') ?>">
							La Lionne
						</a>
					</h1>
				</li>
				<li class="toggle-topbar"><a href="#"></a></li>
			</ul>

			<section>

				<ul class="left">
					<li class="divider"></li>
					<li>
						<a href="<?= url('home.index') ?>">Accueil</a>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Gestion de la course</a>
						<ul class="dropdown">
							<li>
								<a href="#">Etat de la course</a>
							</li>
							<li>
								<a href="#">Ajouter une course</a>
							</li>
							<li>
								<a href="#">Démarrer la course</a>
							</li>
							<li>
								<a href="#">Saisie des départs</a>
							</li>
							<li>
								<a href="#">Saisie des retours</a>
							</li>
							<li>
								<a href="#">Clôturer de la course</a>
							</li>
							<li>
								<a href="#">Arrêter la course</a>
							</li>
							<li>
								<a href="#">Gestion des récompenses</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Gestions des courses</a>
						<ul class="dropdown">
							<li>
								<a href="<?= url('race.display') ?>">Afficher toutes les courses</a>
							</li>
							<li>
								<a href="#">Modifier une course</a>
							</li>
							<li>
								<a href="#">Ajouter une nouvelle course</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Gestions des cyclistes</a>
						<ul class="dropdown">
							<li>
								<a href="#">Afficher les cyclistes</a>
							</li>
							<li>
								<a href="#">Rechercher un cyclciste</a>
							</li>
							<li>
								<a href="#">Ajouter un nouveau cycliste</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Impression</a>
						<ul class="dropdown">
							<li>
								<a href="#">Diplômes</a>
							</li>
							<li>
								<a href="#">Paramétrage des diplômes</a>
							</li>
							<li>
								<a href="<?= url('display.cyclists') ?>">Liste des cyclistes</a>
							</li>
							<li>
								<a href="#">Liste des courses</a>
							</li>
							<li>
								<a href="#">Etiquettes</a>
							</li>
							<li>
								<a href="#">Paramétrage des étiquettes</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Statistiques</a>
						<ul class="dropdown">
							<li>
								<a href="#">Statistiques par années</a>
							</li>
							<li>
								<a href="#">Bilan global</a>
							</li>
							<li>
								<a href="#">Bilan global (EXCEL)</a>
							</li>
							<li>
								<a href="#">Bilan simplifié</a>
							</li>
							<li>
								<a href="#">Bilan simplifié (EXCEL)</a>
							</li>
						</ul>
					</li>
					<li class="divider hide-for-small"></li>
				</ul>

				<!-- Right Nav Section -->
				<ul class="right">
					<li class="divider show-for-medium-and-up"></li>
					<li class="has-button">
						<a class="small button" href="<?= url('login.logout') ?>">
							Se déconnecter
						</a>
					</li>
				</ul>
			</section>
		</nav>
	<?php endif; ?>

	<?php foreach(Session::getInstance()->getFlashes() as $flash): ?>
		<div class="row">
			<?= $flash ?>
		</div>
	<?php endforeach; ?>

	<?= $layoutContents ?>

</body>
</html>