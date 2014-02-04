<h1>�tat de la course</h1>

<div class="row">
	<?php if($raceStatus == "notStarted"): ?>
		<div class="alert-box">
			La course n'a pas encore commenc�.
		</div>
	<?php elseif($raceStatus == "started"): ?>
		<div class="alert-box">
			La course est en cours.
		</div>
	<?php elseif($raceStatus == "ended"): ?>
		<div class="alert-box">
			La course est termin�e.
		</div>
	<?php endif; ?>
</div>

<div class="row">
	<div class="twelve centered columns">
		<div class="row">
			<table class="twelve">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Circuit 1 (<?= e($distances[1]) ?> km)</th>
						<th>Circuit 2 (<?= e($distances[2]) ?> km)</th>
						<th>Circuit 3 (<?= e($distances[3]) ?> km)</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>D�parts</th>
						<td><?= e($departures[1]) ?></td>
						<td><?= e($departures[2]) ?></td>
						<td><?= e($departures[3]) ?></td>
						<th><?= e($totalDepartures) ?></th>
					</tr>
					<tr>
						<th>Arriv�es</th>
						<td><?= e($arrivals[1]) ?></td>
						<td><?= e($arrivals[2]) ?></td>
						<td><?= e($arrivals[3]) ?></td>
						<th><?= e($totalArrivals) ?></th>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="row">
			<table class="twelve">
				<thead>
					<tr>
						<th>Participations</th>
						<th>R�compense</th>
						<th>Nombre</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($rewards as $i => $reward): ?>
						<tr>
							<td><?= e($i) ?></td>
							<td><?= e($reward) ?></td>
							<td><?= e($participations[$i]) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="twelve centered columns">
		<div class="row">
			<div class="four columns text-center">
				<a class="large button" href="<?= url('thisRace.enterDeparture') ?>">Saisir les d�parts</a>
			</div>
			<div class="four columns text-center">
				<a class="large button" href="<?= url('thisRace.enterArrival') ?>">Saisir les arriv�es</a>
			</div>
			<div class="four columns text-center">
				<a class="large button" href="#">Cl�turer la course</a>
			</div>
		</div>
	</div>
</div>