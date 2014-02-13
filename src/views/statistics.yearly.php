<h1>Statistiques</h1>

<div class="row">
	<div class="six centered columns">
		<div class="row">
			<table class="twelve">
				<tr>
					<th class="six">Nombre de personnes du fichier</th>
					<td class="six"><?= $nbTotalCyclists ?></td>
				</tr>
				<tr>
					<th>Nombre de départs déjà pris</th>
					<td><?= $nbDepartures ?></td>
				</tr>
				<tr>
					<th>Nombre de retours saisis</th>
					<td><?= $nbArrivals ?></td>
				</tr>
				<tr>
					<th>Nombre de personnes non rentrées</th>
					<td><?= $nbMissing ?></td>
				</tr>
				<?php foreach($nbPerCircuit as $circuit => $participants): ?>
					<tr>
						<th>Nombre de départs pour <?= e($distances[$circuit]) ?>&nbsp;km</td>
						<td><?= $participants ?></td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<th>Participant le plus âgé</th>
					<td><?= e($oldestCyclist['polit'] . ' ' . $oldestCyclist['nom']
							. ' ' . $oldestCyclist['prenom'] . ', ' . $oldestCyclist['ville'] . ' ('
							. $oldestCyclist['date_n']->format('d/m/Y') . ')') ?></td>
				</tr>
				<tr>
					<th>Participant le plus jeune</th>
					<td><?= e($youngestCyclist['polit'] . ' ' . $youngestCyclist['nom']
							. ' ' . $youngestCyclist['prenom'] . ', ' . $youngestCyclist['ville'] . ' ('
							. $youngestCyclist['date_n']->format('d/m/Y') . ')') ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>