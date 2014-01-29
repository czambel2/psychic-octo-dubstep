<h1>Liste des cyclistes</h1>

<div class="row">
	<table class="twelve contains-data">
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
			<?php foreach($cyclists as $cyclist): ?>
				<tr>
					<td><?= e($cyclist["numcyc"]) ?></td>
					<td><?= e($cyclist["nom"]) ?></td>
					<td><?= e($cyclist["prenom"]) ?></td>
					<td><?= e($cyclist["adresse"]) ?></td>
					<td><?= e($cyclist["ville"]) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>