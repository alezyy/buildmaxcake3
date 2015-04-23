<div class="orderDetails index span8">
	<h2><?php echo __('Order Details'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('order_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($orderDetails as $orderDetail): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($orderDetail['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderDetail['Order']['id'])); ?>
		</td>
		<td><?php echo h($orderDetail['OrderDetail']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($orderDetail['OrderDetail']['name_fr']); ?>&nbsp;</td>
		<td><?php echo h($orderDetail['OrderDetail']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($orderDetail['OrderDetail']['price']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $orderDetail['OrderDetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $orderDetail['OrderDetail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $orderDetail['OrderDetail']['id']), null, __('Are you sure you want to delete # %s?', $orderDetail['OrderDetail']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Order Detail'), array('action' => 'add')); ?></li>
	</ul>
</div>
