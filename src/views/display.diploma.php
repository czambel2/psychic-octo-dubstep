<h1>Impression des diplômes</h1>

<form action="" method="post">
	<div class="row">
		<div class="six centered columns">
			<?= $form ?>
		</div>
	</div>

	<div class="row">
		<div class="five centered columns text-center">
			<ul class="button-group even two-up">
				<li>
					<button class="button" type="submit" name="data[action]" value="printOne">
						Imprimer le diplôme
					</button>
				</li>
				<li>
					<button class="button" type="submit" name="data[action]" value="printAll">
						Imprimer tous les diplômes
					</button>
				</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="five centered columns text-center">
			<button class="button" type="submit" name="data[action]" value="printMissing">
				Imprimer tous les diplômes des cyclistes non rentrés
			</button>
		</div>
	</div>
</form>