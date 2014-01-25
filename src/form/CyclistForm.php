<?php

class CyclistForm extends Form {
	function __construct() {
		parent::__construct();
		$this->data['title'] = 'm';
		$this->data['category'] = ' ';
	}

	protected function validate() {
		$this->check()->required('title');
		$this->check()->inList('title', array('M', 'MME', 'MLLE'));

		$this->check()->required('lastName');
		$this->check()->length('lastName', null, 25);

		$this->check()->required('firstName');
		$this->check()->length('lastName', null, 20);

		$this->check()->email('email');

		$this->check()->date('birthDate');

		$this->check()->required('address');
		$this->check()->length('address', null, 35);

		$this->check()->required('zipcode');
		$this->check()->length('zipcode', null, 5);

		$this->check()->required('city');
		$this->check()->length('city', null, 25);

		$this->check()->length('factory', null, 4);

		$this->check()->length('factoryAddress', null, 100);

		$this->check()->length('ascap', null, 7);

		$this->check()->required('category');
		$this->check()->inList('category', array(' ', 'ACT', 'CNJ', 'ECT', 'ENF', 'EXT', 'M', 'RET'));
	}

	public function __toString() {
		return <<<FORM
<div class="row">
	<div class="two columns">
		<label for="data_title" class="right inline">Titre&nbsp;:</label>
	</div>
	<div class="ten columns">
		<label for="data_title_m">
			<input name="data[title]" required="required" type="radio" id="data_title_m" value="M"{$this->valueChecked('title', 'M')} />
			Monsieur
		</label>

		<label for="data_title_mme">
			<input name="data[title]" required="required" type="radio" id="data_title_mme" value="MME"{$this->valueChecked('title', 'MME')} />
			Madame
		</label>

		<label for="data_title_mlle">
			<input name="data[title]" required="required" type="radio" id="data_title_mlle" value="MLLE"{$this->valueChecked('title', 'MLLE')} />
			Mademoiselle
		</label>

		{$this->errorMessage('title')}
	</div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_lastName" class="right inline">Nom&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[lastName]" required="required" maxlength="25" type="text" id="data_lastName" value="{$this->valueEscaped('lastName')}"{$this->errorClass('lastName')} />
		{$this->errorMessage('lastName')}
	</div>
	<div class="two columns">
		<label for="data_firstName" class="right inline">Prénom&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[firstName]" required="required" maxlength="20" type="text" id="data_firstName" value="{$this->valueEscaped('firstName')}"{$this->errorClass('firstName')} />
		{$this->errorMessage('firstName')}
	</div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_email" class="right inline">Adresse e-mail&nbsp;:</label>
	</div>
	<div class="ten columns">
		<input name="data[email]" type="email" id="data_email" value="{$this->valueEscaped('email')}"{$this->errorClass('email')} />
		{$this->errorMessage('email')}
	</div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_birthDate" class="right inline">Date de naissance&nbsp;:</label>
	</div>
	<div class="ten columns">
		<input name="data[birthDate]" required="required" type="date" id="data_birthDate" value="{$this->valueEscaped('birthDate')}"{$this->errorClass('birthDate')} />
		{$this->errorMessage('birthDate')}
	</div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_address" class="right inline">Adresse&nbsp;:</label>
	</div>
	<div class="ten columns">
		<input name="data[address]" required="required" maxlength="35" type="text" id="data_address" value="{$this->valueEscaped('address')}"{$this->errorClass('address')} />
		{$this->errorMessage('address')}
	</div>
</div>


<div class="row">
	<div class="two columns">
		<label for="data_zipcode" class="right inline">Code postal&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[zipcode]" required="required" maxlength="5" type="text" id="data_zipcode" value="{$this->valueEscaped('zipcode')}"{$this->errorClass('zipcode')} />
		{$this->errorMessage('zipcode')}
	</div>
	<div class="two columns">
		<label for="data_city" class="right inline">Ville&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[city]" required="required" maxlength="25" type="text" id="data_city" value="{$this->valueEscaped('city')}"{$this->errorClass('city')} />
		{$this->errorMessage('city')}
	</div>
</div>

<div class="row">
	<div class="two columns">
		<label for="data_factory" class="right inline">Usine&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[factory]" maxlength="4" type="text" id="data_factory" value="{$this->valueEscaped('factory')}"{$this->errorClass('factory')} />
		{$this->errorMessage('factory')}
	</div>
	<div class="two columns">
		<label for="data_factoryAddress" class="right inline">Adresse usine&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[factoryAddress]" maxlength="100" type="text" id="data_factoryAddress" value="{$this->valueEscaped('factoryAddress')}"{$this->errorClass('factoryAddress')} />
		{$this->errorMessage('factoryAddress')}
	</div>
</div>


<div class="row">
	<div class="two columns">
		<label for="data_ascap" class="right inline">Numéro ASCAP&nbsp;:</label>
	</div>
	<div class="four columns">
		<input name="data[ascap]" maxlength="7" type="number" id="data_ascap" value="{$this->valueEscaped('ascap')}"{$this->errorClass('ascap')} />
		{$this->errorMessage('ascap')}
	</div>
	<div class="two columns">
		<label for="data_category" class="right inline">Catégorie&nbsp;:</label>
	</div>
	<div class="four columns">
		<select name="data[category]" id="data_category"{$this->errorClass('category')}>
			<option value=" "{$this->valueSelected('category', ' ')}></option>
			<option value="ACT"{$this->valueSelected('category', 'ACT')}>ACT</option>
			<option value="CNJ"{$this->valueSelected('category', 'CNJ')}>CNJ</option>
			<option value="ECT"{$this->valueSelected('category', 'ECT')}>ECT</option>
			<option value="ENF"{$this->valueSelected('category', 'ENF')}>ENF</option>
			<option value="EXT"{$this->valueSelected('category', 'EXT')}>EXT</option>
			<option value="M"{$this->valueSelected('category', 'M')}>M</option>
			<option value="RET"{$this->valueSelected('category', 'RET')}>RET</option>
		</select>
		{$this->errorMessage('category')}
	</div>
</div>

<input type="hidden" name="form" value="cyclist" />

FORM;

	}
}