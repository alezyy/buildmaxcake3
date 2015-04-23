<?php echo $this->Form->create(); ?>
<fieldset>
	<legend>
		<?php echo __('Continuing to this page will erase the order in your basket. Continue?'); ?>
	</legend>
	<?php echo $this->Form->hidden('destinationPage', array('value' => $destinationPage));?>
	<?php echo $this->Form->hidden('originalRestaurant', array('value' => $originalRestaurant));?>
	<?php echo $this->Form->submit(__('NO'), array('name' => 'no')); ?> <?php echo __('(Keep your order and go back to the previous restaurant)'); ?>	
	<?php echo $this->Form->submit(__('YES'), array('name' => 'yes')); ?> <?php echo __('(Delete your order and go to the new restaurant)'); ?>	
	
	<?php echo $this->Form->end();?>
		
</fieldset>