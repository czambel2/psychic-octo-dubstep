<h1>Liste des Courses</h1>

<table>
	<tr>
		<th>Numéro</th>
		<th>Date</th>
		<th>Année</th>
		<th>Nombre de participants</th>
		<th>Distance C1</th>
		<th>Distance C2</th>
		<th>Distance C2</th>
	</tr>
	<?php foreach($courses as $course): ?>
		<tr>
			<td><?= $course["numcourse"] ?></td>
			<td><?= $course["datecourse"] ?></td>
			<td><?= $course["anneecourse"] ?></td>
			<td><?= $course["nbparticipantstotal"] ?></td>
			<td><?= $course["distancec1"] ?></td>
			<td><?= $course["distancec2"] ?></td>
			<td><?= $course["distancec3"] ?></td>
		</tr>
	<?php endforeach; ?>

</table>