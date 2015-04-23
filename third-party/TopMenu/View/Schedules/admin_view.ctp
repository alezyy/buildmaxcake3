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
$this->Html->addCrumb(__('View Schedule'));
?>
<div class="schedules view span10">
<h2><?php echo __('Schedule'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($schedule['Location']['name'], array('controller' => 'locations', 'action' => 'view', $schedule['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Day'); ?></dt>
		<dd>
			<?php echo $this->Day->day($schedule['Schedule']['day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opening Hour'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['opening_hour']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Closing Hour'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['closing_hour']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery Start1'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['delivery_start1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery End1'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['delivery_end1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery Start2'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['delivery_start2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery End2'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['delivery_end2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Split Delivery Time'); ?></dt>
		<dd>
			<?php echo h($schedule['Schedule']['split_delivery_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Schedule'), array('action' => 'edit', $location_id, $schedule['Schedule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Schedule'), array('action' => 'delete', $location_id,  $schedule['Schedule']['id']), null, __('Are you sure you want to delete # %s?', $schedule['Schedule']['id'])); ?> </li>
	</ul>
</div>
