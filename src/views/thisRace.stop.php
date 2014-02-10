<h1>Arrêter la course</h1>

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

<form action="" method="post">
	<div class="row">
		<div class="twelve centered columns text-center">
			<form method="post" action="">
				<input type="hidden" name="form" value="stopRace" />
				<button type="submit" class="large button">
					Arrêter la course
				</button>
			</form>
		</div>
	</div>
</form>
