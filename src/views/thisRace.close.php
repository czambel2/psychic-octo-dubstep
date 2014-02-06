<h1>Clôturer la course</h1>

<div class="row">
	<div class="twelve centered columns text-center">
		<h2>
			<small>
				Course cycliste n<sup>o</sup> <?= e($race['numcourse']) ?> du
				<?= DateTime::createFromFormat('Y-m-d H:i:s', $race['datecourse'])->format('d/m/Y') ?>
			</small>
		</h2>
	</div>
</div>

<div class="row" style="margin: 24px;">
	<div class="twelve columns text-center">
		<p>
			Clôturer la course va affecter une heure de retour définie à tous les cyclistes qui ne sont pas passés à
			 l'enregistrement du retour ou ayant abandonné.
		</p>
	</div>
</div>

<form action="" method="post">
	<div class="row" style="margin: 16px">
		<div class="three columns centered">
			<?= $form ?>
		</div>
	</div>

	<div class="row">
		<div class="twelve centered columns text-center">
			<form method="post" action="">
				<input type="hidden" name="form" value="startRace" />
				<button type="submit" class="large button">
					Clôturer la course
				</button>
			</form>
		</div>
	</div>
</form>
