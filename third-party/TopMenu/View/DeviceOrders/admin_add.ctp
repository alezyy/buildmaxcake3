<div class="deviceOrders form span8">
<?php echo $this->Form->create('DeviceOrder'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Device Order'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Device Orders'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
	</ul>
</div>
