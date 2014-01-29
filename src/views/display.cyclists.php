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
					<td><?= e($cycliste["numcyc"]) ?></td>
					<td><?= e($cycliste["nom"]) ?></td>
					<td><?= e($cycliste["prenom"]) ?></td>
					<td><?= e($cycliste["adresse"]) ?></td>
					<td><?= e($cycliste["ville"]) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>