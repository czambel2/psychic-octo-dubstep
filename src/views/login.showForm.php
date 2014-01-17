<h1>
	<a href="<?= basePath() ?>/">La Lionne - Souvenir Jacques Humbert</a>
</h1>

<div class="row">
	<p class="eight columns centered text-centered message">
		Veuillez vous identifier pour accéder à cette page.
	</p>
</div>

<div class="row">
	<form class="lisere five columns centered" action="<?= url('login', 'showForm') ?>" method="post">

		<input type="hidden" name="data[form]" value="login" />

		<div class="row">
			<p class="twelve columns">
				<label for="password">Mot de passe</label>
				<input type="password" name="data[login][password]" id="password" autofocus="autofocus" />
				<?php if(array_key_exists('data', $_POST)): ?>
					<small class="error">Le mot de passe entré est incorrect. Veuillez réessayer.</small>
				<?php endif; ?>
			</p>
		</div>

		<div class="row">
			<p class="twelve columns text-centered">
				<button type="submit" class="button">Connexion</button>
			</p>
		</div>

	</form>
</div>