<h1>Liste des courses</h1>

<div class="row">
	<table class="twelve columns contains-data first-desc">
		<thead>
			<tr>
				<th>Num�ro</th>
				<th>Date</th>
				<th>Ann�e</th>
				<th>Participants</th>
				<th>Distance C1</th>
				<th>Distance C2</th>
				<th>Distance C2</th>
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
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>