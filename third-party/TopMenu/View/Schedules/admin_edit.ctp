<?php
$this->Html->addCrumb(__('Locations'), array(
	'controller' => 'locations',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Location'), array(
	'controller' => 'locations',
	'action' => 'view',
	$location_id
));
$this->Html->addCrumb(__('Schedules'), array(
	'controller' => 'schedules',
	'action' => 'index',
	$location_id
));
$this->Html->addCrumb(__('Edit Schedule'));
?>
<div class="schedules form span10">
<?php echo $this->Form->create('Schedule'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Schedule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Day->day_input('day');
		echo $this->Form->input('opening_hour', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('closing_hour', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('delivery_start1', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('delivery_end1', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('delivery_start2', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('delivery_end2', array('type' => 'time', 'empty' => true));
		echo $this->Form->input('split_delivery_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
