<div class="deliveryAddresses index span8">
	<h2><?php echo __('Delivery Addresses'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('postal_code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($deliveryAddresses as $deliveryAddress): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($deliveryAddress['User']['email'], array('controller' => 'users', 'action' => 'view', $deliveryAddress['User']['id'])); ?>
		</td>
		
		<td><?php echo h($deliveryAddress['DeliveryAddress']['address']); ?>&nbsp;</td>

		<td><?php echo h($deliveryAddress['DeliveryAddress']['city']); ?>&nbsp;</td>
		<td><?php echo h($deliveryAddress['DeliveryAddress']['state']); ?>&nbsp;</td>
		<td><?php echo h($deliveryAddress['DeliveryAddress']['postal_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $deliveryAddress['DeliveryAddress']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Delivery Address'), array('action' => 'add')); ?></li>
	</ul>
</div>
