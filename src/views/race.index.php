<h1>Liste des courses</h1>

<div class="row">
	<table class="twelve">
		<thead>
			<tr>
				<th>Numéro</th>
				<th>Date</th>
				<th>Année</th>
				<th>Participants</th>
				<th>Distance C1</th>
				<th>Distance C2</th>
				<th>Distance C2</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($courses as $course): ?>
				<tr>
					<td><?= $course["numcourse"] ?></td>
					<td><?= empty($course["datecourse"]) ? null : (new DateTime($course["datecourse"]))->format('d/m/Y') ?></td>
					<td><?= $course["anneecourse"] ?></td>
					<td><?= $course["nbparticipantstotal"] ?></td>
					<td><?= $course["distancec1"] ?></td>
					<td><?= $course["distancec2"] ?></td>
					<td><?= $course["distancec3"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>