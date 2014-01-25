<?php

class CyclistForm extends Form {
	function __construct() {
		$this->data['title'] = 'm';
		$this->data['category'] = ' ';
	}

	protected function validate() {
		if(!array_key_exists('title', $this->data) or $this->data['title'] == null) {
			$this->addError('title', 'Veuillez sélectionner le titre.');
		} elseif(!in_array($this->data['title'], array('m', 'mme', 'mlle'))) {
			$this->addError('title', 'Le titre est invalide.');
		}

		if(!array_key_exists('lastName', $this->data) or $this->data['lastName'] == null) {
			$this->addError('lastName', 'Veuillez entrer un nom.');
		} elseif(strlen($this->data['lastName']) > 25) {
			$this->addError('lastName', 'Le nom entré est trop long.');
		}

		if(!array_key_exists('firstName', $this->data) or $this->data['firstName'] == null) {
			$this->addError('firstName', 'Veuillez entrer un prénom.');
		} elseif(strlen($this->data['firstName']) > 20) {
			$this->addError('firstName', 'Le prénom entré est trop long.');
		}

		if(array_key_exists('email', $this->data) and $this->data['email'] != null) {
			if(!preg_match('#^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$#i', $this->data['email'])) {
				$this->addError('email', 'L\'adresse e-mail entrée est invalide.');
			}
		}

		if(array_key_exists('birthDate', $this->data) and $this->data['birthDate'] != null) {
			$matches = array();
			if(preg_match('#^([0-9]{1,2})[/\- ]?([0-9]{1,2})[/\- ]?([0-9]{2,4})$#', $this->data['birthDate'], $matches)) {
				try {
					if(strlen($matches[3]) == 2) {
						$matches[3] += 1900;
					}

					$dateTime = DateTime::createFromFormat('d/m/Y', $matches[1] . '/' . $matches[2] . '/' . $matches[3]);
					if($dateTime->format('d/m/Y') != $matches[1] . '/' . $matches[2] . '/' . $matches[3]) {
						$this->addError('birthDate', 'La date entrée est invalide.');
					} else {
						$this->setData('birthDate', $dateTime);
					}
				} catch(Exception $ex) {
					$this->addError('birthDate', 'La date entrée est invalide.');
				}
			} else {
				$this->addError('birthDate', 'La date entrée est invalide.');
			}
		}

		if(!array_key_exists('address', $this->data) or $this->data['address'] == null) {
			$this->addError('address', 'Veuillez entrer une adresse.');
		} elseif(strlen($this->data['address']) > 35) {
			$this->addError('address', 'L\'adresse entrée est trop longue.');
		}

		if(!array_key_exists('zipcode', $this->data) or $this->data['zipcode'] == null) {
			$this->addError('zipcode', 'Veuillez entrer un code postal.');
		} elseif(strlen($this->data['zipcode']) > 5) {
			$this->addError('zipcode', 'Le code postal entré est trop long.');
		}

		if(!array_key_exists('city', $this->data) or $this->data['city'] == null) {
			$this->addError('city', 'Veuillez entrer une ville.');
		} elseif(strlen($this->data['city']) > 25) {
			$this->addError('city', 'La ville entrée est trop longue.');
		}

		if(array_key_exists('factory', $this->data) and $this->data['factory'] != null) {
			if(strlen($this->data['factory']) > 4) {
				$this->addError('factory', 'L\'usine entrée est trop longue.');
			}
		}

		if(array_key_exists('factoryAddress', $this->data) and $this->data['factoryAddress'] != null) {
			if(strlen($this->data['factoryAddress']) > 100) {
				$this->addError('factoryAddress', 'L\'adresse de l\'usine entrée est trop longue.');
			}
		}

		if(array_key_exists('ascap', $this->data) and $this->data['ascap'] != null) {
			if(strlen($this->data['ascap']) > 7) {
				$this->addError('ascap', 'Le numéro ASCAP entré est trop long.');
			}
		}

		if(!array_key_exists('category', $this->data) or $this->data['category'] == null) {
			$this->addError('category', 'Veuillez sélectionner la catégorie.');
		} elseif(!in_array($this->data['category'], array(' ', 'ACT', 'CNJ', 'ECT', 'ENF', 'EXT', 'M', 'RET'))) {
			$this->addError('title', 'Le titre est invalide.');
		}
	}

	public function __toString() {
		return <<<FORM
<div class="row">
	<div class="two columns">
		<label for="data_title" class="right inline">Titre&nbsp;:</label>
	</div>
	<div class="ten columns">
		<label for="data_title_m">
			<input name="data[title]" required="required" type="radio" id="data_title_m" value="m"{$this->valueChecked('title', 'm')} />
			Monsieur
		</label>

		<label for="data_title_mme">
			<input name="data[title]" required="required" type="radio" id="data_title_mme" value="mme"{$this->valueChecked('title', 'mme')} />
			Madame
		</label>

		<label for="data_title_mlle">
			<input name="data[title]" required="required" type="radio" id="data_title_mlle" value="mlle"{$this->valueChecked('title', 'mlle')} />
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