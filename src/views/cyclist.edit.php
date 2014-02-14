<h1>Modification d'un cycliste</h1>

<form action="" method="post" novalidate="novalidate">
	<div class="row">
		<div class="nine columns centered">
			<?= $form ?>

			<div class="row">
				<div class="three column centered text-center">
					<ul class="button-group even two-up">
						<li><button class="button" type="submit">Modifier</button></li>
						<li><a class="button" href="<?= $returnUrl ?: url('cyclist.index') ?>">Annuler</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>