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
				<th>&nbsp;</th>
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
					<td class="text-center"><a class="edit-button" title="Modifier" href="<?= url('cyclist.edit') ?>?id=<?= $cyclist["numcyc"] ?>">Modifier</a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>