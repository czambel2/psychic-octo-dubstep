<h1>État de la course</h1>

<?php if($raceStatus == 'inexistant'): ?>
	<div class="row">
		<div class="twelve centered columns">
			<div class="alert-box">
				Aucune course ce jour, veuillez consulter la
				liste des courses.
			</div>

			<div class="row text-center">
				<div class="five centered columns">
					<a class="button" href="<?= url('race.index') ?>">Liste des courses</a>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php if($raceStatus == "started" or $raceStatus == "ended"): ?>
		<div class="row">
			<?php if($raceStatus == "started"): ?>
				<div class="alert-box">
					La course est en cours.
				</div>
			<?php elseif($raceStatus == "ended"): ?>
				<div class="alert-box">
					La course est terminée.
				</div>
			<?php endif; ?>
		</div>
	<?php else: ?>
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

		<div style="margin: 8px;">&nbsp;</div>

		<div class="row">
			<div class="twelve centered columns text-center">
				<form method="post" action="">
					<input type="hidden" name="form" value="startRace" />
					<button type="submit" class="large button">
						Lancer la course
					</button>
				</form>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>