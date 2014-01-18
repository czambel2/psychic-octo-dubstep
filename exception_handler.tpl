<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="fr"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="fr"><!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Lionne</title>

	<link rel="stylesheet" type="text/css" href="<?= $basePath ?>/assets/css/foundation.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= $basePath ?>/assets/css/style.css" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?= $basePath ?>/assets/js/foundation/modernizr.foundation.js"></script>
	<script src="<?= $basePath ?>/assets/js/script.js"></script>
</head>
<body class="special">
	<div class="row">
		<div class="eight columns centered text-centered">
			<h1>
				<a href="<?= url('home.index'); ?>"><?= $errorTitle; ?></a>
			</h1>
		</div>
	</div>
	<div class="row">
		<p class="eight columns centered text-centered message">
			Une erreur s'est produite lors du traitement de votre demande.
		</p>
	</div>
	<div class="row">
		<p class="eight columns centered text-centered exception message"><?= $errorMessage ?></p>
	</div>
	<?php if($errorTrace): ?>
	<div class="row">
		<pre class="eight columns centered exception trace"><?= $errorTrace ?></pre>
	</div>
	<?php endif; ?>
	<div class="row">
		<p class="eight columns centered text-centered message">
			Si vous êtes perdu, vous pouvez <a href="<?= url('home.index') ?>">retourner à la page d'accueil</a>.
		</p>
	</div>
</body>
</html>