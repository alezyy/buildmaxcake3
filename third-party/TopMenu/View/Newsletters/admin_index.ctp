<div class="newsletters index span8">
	<h2><?php echo __('Newsletters'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('telephone'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($newsletters as $newsletter): ?>
	<tr>
		<td><?php echo h($newsletter['Newsletter']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['telephone']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['email']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $newsletter['Newsletter']['id']), null, __('Are you sure you want to delete # %s?', $newsletter['Newsletter']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Newsletter'), array('action' => 'add')); ?></li>
	</ul>
</div>
