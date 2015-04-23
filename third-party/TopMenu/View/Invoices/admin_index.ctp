<?php
$this->Html->addCrumb(__('Invoices'));
?>
<div class="invoices index span10">
	<h2><?php echo __('Invoices'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('restaurant_id'); ?></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_number'); ?></th>
			<th><?php echo $this->Paginator->sort('from_date'); ?></th>
			<th><?php echo $this->Paginator->sort('to_date'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('total_amount'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invoices as $invoice): ?>
	<tr>
		<td>
			<?php
			echo $this->Html->link(
				$invoice['Restaurant']['name'],
				array(
					'controller' => 'restaurants',
					'action' => 'view',
					$invoice['Restaurant']['id']
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $this->Html->link(
				$invoice['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$invoice['Location']['id']
				)
			);
			?>
		</td>
		<td><?php echo h($invoice['Invoice']['invoice_number']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['from_date']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['to_date']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['status']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['total_amount']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $invoice['Invoice']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invoice['Invoice']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Invoice'), array('action' => 'add')); ?></li>
	</ul>
</div>
