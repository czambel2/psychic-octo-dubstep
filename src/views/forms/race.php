<div class="row">
	<div class="two columns">
		<label for="data_date" class="right inline required">Date&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[date]" required="required" type="date" id="data_date" value="<?= $this->valueEscaped('date') ?>"<?= $this->errorClass('date') ?> />
		<?= $this->errorMessage('date') ?>
	</div>
	<div class="six columns"></div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_circuit1" class="right inline required">Circuit 1&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[circuit1]" required="required" type="number" id="data_circuit1" value="<?= $this->valueEscaped('circuit1') ?>"<?= $this->errorClass('circuit1') ?> />
		<?= $this->errorMessage('circuit1') ?>
	</div>
	<div class="six columns"></div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_circuit2" class="right inline required">Circuit 2&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[circuit2]" required="required" type="number" id="data_circuit2" value="<?= $this->valueEscaped('circuit2') ?>"<?= $this->errorClass('circuit2') ?> />
		<?= $this->errorMessage('circuit2') ?>
	</div>
	<div class="six columns"></div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_circuit3" class="right inline required">Circuit 3&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[circuit3]" required="required" type="number" id="data_circuit3" value="<?= $this->valueEscaped('circuit3') ?>"<?= $this->errorClass('circuit3') ?> />
		<?= $this->errorMessage('circuit3') ?>
	</div>
	<div class="six columns"></div>
</div>

<input type="hidden" name="form" value="race" />