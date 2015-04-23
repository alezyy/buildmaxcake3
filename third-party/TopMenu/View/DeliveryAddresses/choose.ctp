<?php
echo $this->Form->create('DeliveryAddress', array(
	'action' => 'choose',
	'default' => false));
?>
<fieldset>


	<?php
	if (empty($success)) {
		?>
		<legend><?php echo __('Select an existing address'); ?></legend>				
		<?php echo $this->Form->input('deliveryAddress'); ?>
		
		<?php
		echo $this->Form->end(
			array(
				'class' => 'btn btn-danger pull-right',
				'label' => __('OK'),
				'tabindex' => 2
			)
		);
	} else {
		echo $success;
		echo $this->Form->button(__('Close'), array(
			'class' => 'btn btn-danger pull-right',
			'id' => 'closeModal',
			'tabindex' => 2
		));

		echo $this->Html->script('close_modal');
		echo $this->Js->writeBuffer();
	}
	?>
</fieldset>	