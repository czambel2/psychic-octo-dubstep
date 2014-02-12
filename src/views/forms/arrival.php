<div class="row">
	<div class="three columns">
		<label for="data_cyclistName" class="right inline required">Coureur&nbsp;:</label>
	</div>
	<div class="nine columns">
		<input data-race-number="<?= $this->getMiscData('raceNumber') ?>" name="data[cyclistName]" class="autocomplete-cyclists-filter arrival <?= $this->errorClass('cyclistName', true) ?>" required="required" autofocus="autofocus" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" value="<?= $this->valueEscaped('cyclistName') ?>" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<div class="reward hide">
	<div class="alert-box reward-yes">
		Ce coureur a paticipé à <span class="nbRaces"></span> courses et remporte donc l'objet suivant&nbsp;: <span class="rewardName"></span>.
	</div>
	<div class="alert-box secondary reward-no">
		Ce coureur a participé à <span class="nbRaces"></span> courses et ne gagne pas de récompense aujourd'hui.
	</div>
</div>

<div class="panel radius race hide">
	<p><strong>Circuit&nbsp;:</strong> <span class="circuit"></span></p>
	<p><strong>Distance&nbsp;:</strong> <span class="distance"></span> km</p>
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

<input type="hidden" name="form" value="enterArrival" />