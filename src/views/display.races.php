<h1>Liste des courses</h1>

<div class="row">
	<table class="twelve first-desc">
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
			<?php foreach($races as $race): ?>
				<tr>
					<td><?= $race["numcourse"] ?></td>
					<td><?= empty($race["datecourse"]) ? null : (new DateTime($race["datecourse"]))->format('d/m/Y') ?></td>
					<td><?= $race["anneecourse"] ?></td>
					<td><?= $race["nbparticipantstotal"] ?></td>
					<td><?= $race["distancec1"] ?></td>
					<td><?= $race["distancec2"] ?></td>
					<td><?= $race["distancec3"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>