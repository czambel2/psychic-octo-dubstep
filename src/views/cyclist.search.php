<h1>Rechercher un Cycliste</h1>

<form action="" method="post">
	<div class="row">
		<div class="six centered columns">
			<?= $form ?>
		</div>
	</div>
	<div class="row centered">
		<div class="six centered columns text-centered">
			<button class="button" type="submit">Rechercher</button>
		</div>
	</div>
</form>

<?php if($cyclist): ?>

	<div class="row">
		<div class="six columns centered">
			<div class="row">
				<div class="two columns">Titre</div>
				<div class="ten columns"><?= $cyclist['POLIT'] ?></div>
			</div>
		</div>
	</div>

	<?php var_dump($cyclist); ?>

<?php endif; ?>