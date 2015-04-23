<div class="deviceOrders form span8">
<?php echo $this->Form->create('DeviceOrder'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Device Order'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('order_id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('order_string');
		echo $this->Form->input('recorded_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DeviceOrder.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DeviceOrder.id'))); ?></li>
	</ul>
</div>
