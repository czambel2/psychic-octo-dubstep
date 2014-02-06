<div class="row">
	<div class="six columns">
		<label for="data_hour" class="right inline required">Heure de clôture&nbsp;:</label>
	</div>
	<div class="six columns">
		<input name="data[hour]" required="required" type="time" id="data_hour" value="<?= $this->valueEscaped('hour', 'time') ?>"<?= $this->errorClass('hour') ?> />
		<?= $this->errorMessage('hour') ?>
	</div>
</div>

<input type="hidden" name="form" value="closeRace" />