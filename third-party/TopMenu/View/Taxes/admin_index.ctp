<?php
$this->Html->addCrumb(__('Taxes'));
?>
<div class="taxes index span10">
	<h2><?php echo __('Taxes'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('province'); ?></th>
			<th><?php echo $this->Paginator->sort('percentage'); ?></th>
			<th><?php echo $this->Paginator->sort('compound'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($taxes as $tax): ?>
	<tr>
		<td><?php echo h($tax['Tax']['country']); ?>&nbsp;</td>
		<td><?php echo h($tax['Tax']['province']); ?>&nbsp;</td>
		<td><?php echo h($tax['Tax']['percentage']); ?>&nbsp;</td>
		<td><?php echo h($tax['Tax']['is_compound']); ?>&nbsp;</td>
		<td><?php echo h($tax['Tax']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($tax['Tax']['name_fr']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tax['Tax']['id'])); ?>
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