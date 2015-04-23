<fieldset>

	<?php
	echo $this->Form->input('phone');
	?>

	<div class="control-group">
		<?php
		echo $this->Form->input('address', array(
			'div' => FALSE,
			'no_div' => TRUE));
		echo $this->Form->input('address2', array(
			'label' => '',
			'div' => FALSE,
			'no_div' => TRUE));
		?>
	</div>		
	<?php
	echo $this->Form->input('city');

	echo $this->Form->hidden('DeliveryAddress.province', array(
		'id' => 'provinces',
		'value' => 'Quebec'));

	echo $this->Form->hidden('DeliveryAddress.country', array(
		'empty' => __('Select a Country'),
		'id' => 'country',
		'value' => Configure::read('I18N.COUNTRY_CODE_2')));

	echo $this->Form->input('postal_code');
	echo $this->Form->input('cross_street');

	if (!empty($successPage)) {
		echo $this->Form->hidden('success_page', array('value' => $successPage));
	}

	echo $this->Form->end();
	?>

</fieldset>
