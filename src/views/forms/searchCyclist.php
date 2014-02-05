<div class="row">
	<div class="nine columns centered">
		<input name="data[cyclistName]" class="autocomplete-cyclists" required="required" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" <?= $this->errorClass('cyclistName') ?> />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<div class="panel radius sheet hide">
	<p><strong><span class="title"></span> <span class="lastName"></span> <span class="firstName"></span></strong></p>
	<p><span class="address"></span></p>
	<p><span class="zipcode"></span> <span class="city"></span></p>
</div>

<input type="hidden" name="form" value="searchCyclist" />