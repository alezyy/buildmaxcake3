<div class="deliveryAddresses form span8">
<?php echo $this->Form->create('DeliveryAddress'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Delivery Address'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('phone');
		echo $this->Form->input('secondary_phone');
		echo $this->Form->input('door_code');
		echo $this->Form->input('cross_street');
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('postal_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
