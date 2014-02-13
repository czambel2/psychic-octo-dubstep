<h1>Liste des cyclistes</h1>

<div class="row">
	<table class="twelve">
		<thead>
			<tr>
				<th>Numéro</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Adresse</th>
				<th>Ville</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($cyclistes as $cycliste): ?>
				<tr>
					<td><?= $cycliste["numcyc"] ?></td>
					<td><?= $cycliste["nom"] ?></td>
					<td><?= $cycliste["prenom"] ?></td>
					<td><?= $cycliste["adresse"] ?></td>
					<td><?= $cycliste["ville"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>