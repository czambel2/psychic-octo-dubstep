<div class="row">
	<div class="nine columns centered">
		<input name="data[cyclistName]" class="autocomplete-cyclists-search <?= $this->errorClass('cyclistName', true) ?>" required="required" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<input type="hidden" name="form" value="searchCyclist" />