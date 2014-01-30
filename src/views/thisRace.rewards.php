<h1>Gestion des récompenses</h1>

<div class="row">
	<form class="ajax-editable" action="" method="post">
		<div class="six columns centered">
			<div class="row">
				<table class="twelve">
					<colgroup>
						<col style="width: 15%" />
						<col style="width: 70%" />
						<col style="width: 15%" />
					</colgroup>
					<thead>
					<tr>
						<th>Participations</th>
						<th>Récompense</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($rewards as $reward): ?>
						<tr data-number="<?= e($reward["nbparticipation"]) ?>">
							<td><?= e($reward["nbparticipation"]) ?></td>
							<td>
								<span><?= e($reward["librecompense"]) ?></span>
								<input class="hide-script no-margin" type="text" value="<?= e($reward["librecompense"]) ?>" />
							</td>
							<td class="text-centered">
								<a href="" class="small button modifier-recompense" data-number="<?= e($reward["nbparticipation"]) ?>">Modifier</a>
								<button class="ok-modif-recompense hide-script small button" type="submit">Enregistrer</button>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>

<div class="row">
	<div class="two columns centered text-center">
		<a class="button" href="<?= url('thisRace.addReward') ?>">Ajouter</a>
	</div>
</div>