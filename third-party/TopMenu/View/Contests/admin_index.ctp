<div class="contests index span8">
	<h2><?php echo __('Contests'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('sector'); ?></th>
			<th><?php echo $this->Paginator->sort('registration_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contests as $contest): ?>
	<tr>
		<td><?php echo h($contest['Contest']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($contest['Contest']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($contest['Contest']['sector']); ?>&nbsp;</td>
		<td><?php echo h($contest['Contest']['registration_date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contest['Contest']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contest['Contest']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contest['Contest']['id']), null, __('Are you sure you want to delete # %s?', $contest['Contest']['id'])); ?>
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
	<ul>
		<li><?php echo $this->Html->link(__('New Contest'), array('action' => 'add')); ?></li>
	</ul>
</div>
