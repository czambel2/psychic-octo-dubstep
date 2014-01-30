<div class="row">
	<div class="two columns">
		<label for="data_rewardLabel" class="right inline">Récompense&nbsp;:</label>
	</div>
	<div class="ten columns">
		<input name="data[rewardLabel]" required="required" maxlength="45" type="text" id="data_rewardLabel" value="<?= $this->valueEscaped('rewardLabel') ?>"<?= $this->errorClass('rewardLabel') ?> />
		<?= $this->errorMessage('rewardLabel') ?>
	</div>
</div>

<input type="hidden" name="form" value="reward" />