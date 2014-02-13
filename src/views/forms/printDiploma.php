<div class="row">
	<div class="nine centered columns">
		<input name="data[cyclistName]" class="autocomplete-cyclists diploma no-details <?= $this->errorClass('cyclistName', true) ?>"
		       autofocus="autofocus" id="data_cyclistName" placeholder="Rechercher un cycliste" type="text"
		       value="<?= $this->valueEscaped('cyclistName') ?>" />
		<?= $this->errorMessage('cyclistName') ?>
		<div class="autocomplete-results"></div>
	</div>
</div>

<input type="hidden" name="form" value="printDiploma" />