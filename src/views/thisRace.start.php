<h1>Démarrer la course</h1>

<?php if($raceStatus != 'notStarted'): ?>
	<div class="row">
		<div class="twelve centered columns">
			<?php if($raceStatus == "started"): ?>
				<div class="alert-box">
					Vous ne pouvez pas démarrer la course car elle est déjà en cours.
				</div>
			<?php elseif($raceStatus == "ended"): ?>
				<div class="alert-box">
					Vous ne pouvez pas démarrer la course car elle est déjà terminée.
				</div>
			<?php elseif($raceStatus == "notToday"): ?>
				<div class="alert-box">
					Vous ne pouvez pas démarrer la course car elle n'est pas datée d'aujourd'hui.
				</div>
			<?php endif; ?>

			<div class="row text-center">
				<div class="five centered columns">
					<a class="button" href="<?= url('race.index') ?>">Liste des courses</a>
				</div>
			</div>
		</div>
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