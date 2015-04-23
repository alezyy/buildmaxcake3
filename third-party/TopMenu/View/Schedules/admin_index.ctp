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
$this->Html->addCrumb(__('Schedules'));
?>
<div class="schedules index span10">
	<h2><?php echo __('Schedules'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('day'); ?></th>
			<th><?php echo $this->Paginator->sort('opening_hour'); ?></th>
			<th><?php echo $this->Paginator->sort('closing_hour'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_start1'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_end1'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_start2'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_end2'); ?></th>
			<th><?php echo $this->Paginator->sort('split_delivery_time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($schedules as $schedule): ?>
	<tr>
		<td><?php echo $this->Day->day($schedule['Schedule']['day']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['opening_hour']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['closing_hour']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['delivery_start1']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['delivery_end1']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['delivery_start2']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['delivery_end2']); ?>&nbsp;</td>
		<td><?php echo h($schedule['Schedule']['split_delivery_time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $location_id, $schedule['Schedule']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $location_id,  $schedule['Schedule']['id']), null, __('Are you sure you want to delete # %s?', $schedule['Schedule']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="pagination">
		<ul>
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</ul>
	</div>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('New Schedule'), array('action' => 'add', $location_id)); ?></li>
	</ul>
</div>
