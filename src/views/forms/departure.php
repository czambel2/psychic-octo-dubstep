<div class="row">
	<div class="three columns">
		<label for="data_cyclistName" class="right inline required">Coureur&nbsp;:</label>
	</div>
	<div class="nine columns">
		<input name="data[cyclistName]" class="autocomplete-cyclists departure <?= $this->errorClass('cyclistName', true) ?>" required="required" autofocus="autofocus" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" value="<?= $this->valueEscaped('cyclistName') ?>" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<div class="panel radius sheet hide relative">
	<p><strong><span class="title"></span> <span class="lastName"></span> <span class="firstName"></span></strong></p>
	<p><span class="address"></span></p>
	<p><span class="zipcode"></span> <span class="city"></span></p>

	<p><span class="email"></span></p>
	<p><span class="birthdate"></span></p>

	<div class="edit-details">
		<a href="<?= url('cyclist.edit') ?>" data-baseurl="<?= url('cyclist.edit') ?>" class="small button">Modifier</a>
	</div>
</div>

<div class="panel radius sheet hide">
	<div class="row aerated">
		<div class="two columns">
			<span class="label radius">Participations&nbsp;:</span>
		</div>
		<div class="four columns contains-radio">
			<span class="nbRaces"></span>
		</div>
		<div class="two columns">
			<span class="label radius">Distance totale&nbsp;:</span>
		</div>
		<div class="four columns contains-radio">
			<span class="totalDistance"></span>&nbsp;km
		</div>
	</div>

	<div class="row aerated">
		<div class="two columns">
			<span class="label radius">Récompenses&nbsp;:</span>
		</div>
		<div class="ten columns">
			<span class="rewards">Aucune</span>
		</div>
	</div>
</div>

<div class="row">
	<div class="three columns">
		<label for="data_circuit" class="right inline required">Circuit choisi&nbsp;:</label>
	</div>
	<div class="nine columns">
		<div class="ten columns contains-radio">
			<label for="data_circuit_1">
				<input name="data[circuit]" required="required" type="radio" id="data_circuit_1" value="1"<?= $this->valueChecked('circuit', '1') ?> />
				<?= $this->getMiscData('distances')[1] ?> km
			</label>

			<label for="data_circuit_2">
				<input name="data[circuit]" required="required" type="radio" id="data_circuit_2" value="2"<?= $this->valueChecked('circuit', '2') ?> />
				<?= $this->getMiscData('distances')[2] ?> km
			</label>

			<label for="data_circuit_3">
				<input name="data[circuit]" required="required" type="radio" id="data_circuit_3" value="3"<?= $this->valueChecked('circuit', '3') ?> />
				<?= $this->getMiscData('distances')[3] ?> km
			</label>

			<?= $this->errorMessage('circuit') ?>
		</div>
	</div>
</div>

<input type="hidden" name="form" value="enterDeparture" />