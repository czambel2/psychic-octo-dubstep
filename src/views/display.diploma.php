<h1>Impression des dipl�mes</h1>

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
						Imprimer le dipl�me
					</button>
				</li>
				<li>
					<button class="button" type="submit" name="data[action]" value="printAll">
						Imprimer tous les dipl�mes
					</button>
				</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="five centered columns text-center">
			<button class="button" type="submit" name="data[action]" value="printMissing">
				Imprimer tous les dipl�mes des cyclistes non rentr�s
			</button>
		</div>
	</div>
</form>