<h1>Rechercher un cycliste</h1>

<form action="" method="post">
	<div class="row aerated centered">
		<div class="six centered columns">
			<?= $form ?>
		</div>
	</div>
	<div class="row centered">
		<div class="six centered columns text-centered">
			<button class="button" type="submit">Rechercher</button>
		</div>
	</div>
</form>

<?php if($cyclist): ?>

	<div class="row centered">
		<div class="eight centered columns">
			<div class="panel">
				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Titre&nbsp;:</span>
					</div>
					<div class="ten columns contains-radio">
						<?= e($cyclist['polit']) ?>
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Nom&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['nom']) ?>
					</div>
					<div class="two columns">
						<span class="label radius">Prénom&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['prenom']) ?>
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Adresse e-mail&nbsp;:</span>
					</div>
					<div class="ten columns">
						<?= e($cyclist['email']) ?>
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius ">Date de naissance&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['date_n']->format('d/m/Y')) ?>
					</div>
					<div class="six columns"></div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Adresse&nbsp;:</span>
					</div>
					<div class="ten columns">
						<?= e($cyclist['adresse']) ?>
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Code postal&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['cod_post']) ?>
					</div>
					<div class="two columns">
						<span class="label radius">Ville&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['ville']) ?>
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Usine&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['usine']) ?>
					</div>
					<div class="two columns">
						<span class="label radius">Adresse usine&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['adr_usi']) ?>
					</div>
				</div>


				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Numéro ASCAP&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['ascap']) ?>
					</div>
					<div class="two columns">
						<span class="label radius">Catégorie&nbsp;:</span>
					</div>
					<div class="four columns">
						<?= e($cyclist['cat']) ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row centered">
		<div class="eight centered columns">
			<div class="panel">
				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Participations&nbsp;:</span>
					</div>
					<div class="four columns contains-radio">
						<?= e($cyclist['nbcourses']) ?>
					</div>
					<div class="two columns">
						<span class="label radius">Distance parcourue&nbsp;:</span>
					</div>
					<div class="four columns contains-radio">
						<?= e($cyclist['km']) ?>&nbsp;km
					</div>
				</div>

				<div class="row aerated">
					<div class="two columns">
						<span class="label radius">Récompenses&nbsp;:</span>
					</div>
					<div class="four columns">
						<?php if(empty($rewards)) : ?>
							Aucune
						<?php else: ?>
							<ol>
								<?php foreach($rewards as $reward): ?>
									<li><?= e($reward) ?></li>
								<?php endforeach; ?>
							</ol>
						<?php endif; ?>
					</div>
					<div class="two columns">
						<span class="label radius">Courses&nbsp;:</span>
					</div>
					<div class="four columns">
						<?php if(empty($races)) : ?>
							Aucune
						<?php else: ?>
							<ul>
								<?php foreach($races as $race): ?>
									<li><?= e($race) ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row centered">
		<div class="two centered columns text-center">
			<ul class="button-group even two-up">
				<li>
					<a href="<?= url('cyclist.edit', array('id' => $cyclist['numcyc'], 'returnto' => url('cyclist.search', array('id' => $cyclist['numcyc'])))) ?>" class="button">
						Modifier
					</a>
				</li>
				<li>
					<a href="<?= url('cyclist.index') ?>" class="button">
						Retour
					</a>
				</li>
			</ul>
		</div>
	</div>

<?php endif; ?>