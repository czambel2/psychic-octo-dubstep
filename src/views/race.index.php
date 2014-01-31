<h1>Liste des courses</h1>

<div class="row">
	<table class="twelve contains-data first-desc">
		<thead>
			<tr>
				<th>Numéro</th>
				<th>Date</th>
				<th>Année</th>
				<th>Participants</th>
				<th>Distance C1</th>
				<th>Distance C2</th>
				<th>Distance C2</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($courses as $course): ?>
				<tr>
					<td><?= e($course["numcourse"]) ?></td>
					<td><?= empty($course["datecourse"]) ? null : (new DateTime($course["datecourse"]))->format('d/m/Y') ?></td>
					<td><?= e($course["anneecourse"]) ?></td>
					<td><?= e($course["nbparticipantstotal"]) ?></td>
					<td><?= e($course["distancec1"]) ?></td>
					<td><?= e($course["distancec2"]) ?></td>
					<td><?= e($course["distancec3"]) ?></td>
					<td class="text-center">
						<a class="edit-button" href="<?= url('race.edit', array('id' => $course['numcourse'])) ?>" title="Modifier">Modifier</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>