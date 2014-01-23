<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="fr"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="fr"><!--<![endif]-->
<head>
	<meta charset="iso-8859-1" />
	<meta name="viewport" content="width=device-width" />
	<title>Lionne</title>

	<link rel="stylesheet" type="text/css" href="<?= basePath() ?>/assets/css/foundation.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= basePath() ?>/assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?= basePath() ?>/assets/css/jquery.dataTables.css" />

	<script src="<?= basePath() ?>/assets/js/foundation/modernizr.foundation.js"></script>
	<script src="<?= basePath() ?>/assets/js/foundation/foundation.min.js"></script>
	<script src="<?= basePath() ?>/assets/js/vendor/jquery-ui.min.js"></script>
	<script src="<?= basePath() ?>/assets/js/vendor/jquery.dataTables.min.js"></script>
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
						<a href="#">Gestion de la course actuelle</a>
						<ul class="dropdown">
							<li>
								<a href="#">�tat de la course</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Ajouter une course</a>
							</li>
							<li>
								<a href="#">D�marrer la course</a>
							</li>
							<li>
								<a href="#">Saisie des d�parts</a>
							</li>
							<li>
								<a href="#">Saisie des retours</a>
							</li>
							<li>
								<a href="#">Cl�turer la course</a>
							</li>
							<li>
								<a href="#">Arr�ter la course</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Gestion des r�compenses</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Gestion des courses</a>
						<ul class="dropdown">
							<li>
								<a href="<?= url('race.index') ?>">Afficher toutes les courses</a>
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
						<a href="#">Gestion des cyclistes</a>
						<ul class="dropdown">
							<li>
								<a href="<?= url('cyclist.index') ?>">Afficher les cyclistes</a>
							</li>
							<li>
								<a href="#">Rechercher un cyclciste</a>
							</li>
							<li>
								<a href="<?= url('cyclist.add') ?>">Ajouter un nouveau cycliste</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Impression</a>
						<ul class="dropdown">
							<li>
								<a href="#">Dipl�mes</a>
							</li>
							<li>
								<a href="#">Param�trage des dipl�mes</a>
							</li>
							<li>
								<a href="<?= url('display.cyclists') ?>">Liste des cyclistes</a>
							</li>
							<li>
								<a href="#">Liste des courses</a>
							</li>
							<li>
								<a href="#">�tiquettes</a>
							</li>
							<li>
								<a href="#">Param�trage des �tiquettes</a>
							</li>
						</ul>
					</li>
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="#">Statistiques</a>
						<ul class="dropdown">
							<li>
								<a href="#">Statistiques par ann�e</a>
							</li>
							<li>
								<a href="#">Bilan global</a>
							</li>
							<li>
								<a href="#">Bilan global (Excel)</a>
							</li>
							<li>
								<a href="#">Bilan simplifi�</a>
							</li>
							<li>
								<a href="#">Bilan simplifi� (Excel)</a>
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
							Se d�connecter
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