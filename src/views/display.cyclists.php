<h1>Liste des Cyclistes</h1>

<table>
	<tr>
		<th>Num�ro de Cycliste</th>
		<th>Nom</th>
		<th>Pr�nom</th>
		<th>Adresse</th>
		<th>Ville</th>
	</tr>
	<?php foreach($cyclistes as $cycliste): ?>
		<tr>
			<td><?= $cycliste["numcyc"] ?></td>
			<td><?= $cycliste["nom"] ?></td>
			<td><?= $cycliste["prenom"] ?></td>
			<td><?= $cycliste["adresse"] ?></td>
			<td><?= $cycliste["ville"] ?></td>
		</tr>
	<?php endforeach; ?>

</table>
