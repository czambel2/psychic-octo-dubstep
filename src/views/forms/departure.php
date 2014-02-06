<div class="row">
	<div class="three columns">
		<label for="data_cyclistName" class="right inline required">Coureur&nbsp;:</label>
	</div>
	<div class="nine columns">
		<input name="data[cyclistName]" class="autocomplete-cyclists departure <?= $this->errorClass('cyclistName', true) ?>" required="required" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<div class="panel radius sheet hide">
	<p><strong><span class="title"></span> <span class="lastName"></span> <span class="firstName"></span></strong></p>
	<p><span class="address"></span></p>
	<p><span class="zipcode"></span> <span class="city"></span></p>
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