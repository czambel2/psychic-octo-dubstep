<h1>Liste des cyclistes</h1>

<div class="row">
	<table class="twelve contains-data">
		<thead>
			<tr>
				<th>Num�ro</th>
				<th>Nom</th>
				<th>Pr�nom</th>
				<th>Adresse</th>
				<th>Ville</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($cyclists as $cyclist): ?>
				<tr>
					<td><?= $cyclist["numcyc"] ?></td>
					<td><?= $cyclist["nom"] ?></td>
					<td><?= $cyclist["prenom"] ?></td>
					<td><?= $cyclist["adresse"] ?></td>
					<td><?= $cyclist["ville"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>