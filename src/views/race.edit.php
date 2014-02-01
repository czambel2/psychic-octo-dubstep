<h1>Modification d'une course</h1>

<form action="" method="post" novalidate="novalidate">
	<div class="row">
		<div class="four columns centered">
			<div class="row">
				<div class="three columns">
					<label style="cursor: default" class="right inline">Course n<sup>o</sup>&nbsp;:</label>
				</div>
				<div class="nine columns">
					<label style="margin-top: 8px; cursor: default;"><?= e($raceNumber) ?></label>
				</div>
			</div>

			<?= $form ?>

			<div class="row">
				<div class="one column centered">
					<button class="button" type="submit">Modifier</button>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="row">
	<div class="four columns centered">
		<div class="row">
			<table class="twelve">
				<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Participants</th>
					<th>Retours</th>
				</tr>
				</thead>
				<tbody>
				<?php for($i = 1; $i <= 3; $i++): ?>
					<tr>
						<th>Circuit <?= e($i) ?></th>
						<td><?= e($participants[$i]) ?></td>
						<td><?= e($arrivals[$i]) ?></td>
					</tr>
				<?php endfor; ?>
				<tr>
					<th>Total</th>
					<td><?= e($totalParticipants) ?></td>
					<td><?= e($totalArrivals) ?></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>