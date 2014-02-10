<div class="row">
	<div class="three columns">
		<label for="data_cyclistName" class="right inline required">Coureur&nbsp;:</label>
	</div>
	<div class="nine columns">
		<input data-race-number="<?= $this->getMiscData('raceNumber') ?>" name="data[cyclistName]" class="autocomplete-cyclists-filter arrival <?= $this->errorClass('cyclistName', true) ?>" required="required" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<div class="reward hide">
	<div class="alert-box">
		Ce coureur a paticipé à <span class="nbRaces"></span> courses et remporte donc l'objet suivant&nbsp;: <span class="rewardName"></span>.
	</div>
</div>

<div class="panel radius race hide">
	<p><strong>Circuit&nbsp;:</strong> <span class="circuit"></span></p>
	<p><strong>Distance&nbsp;:</strong> <span class="distance"></span> km</p>
</div>

<div class="panel radius sheet hide">
	<p><strong><span class="title"></span> <span class="lastName"></span> <span class="firstName"></span></strong></p>
	<p><span class="address"></span></p>
	<p><span class="zipcode"></span> <span class="city"></span></p>
</div>



<input type="hidden" name="form" value="enterArrival" />