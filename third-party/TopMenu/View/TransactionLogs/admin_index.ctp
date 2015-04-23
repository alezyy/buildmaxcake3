<?php
$this->Html->addCrumb(__('Transactions'));
?>
<script>
    $('#content_home').css('width', '95%');
</script>
<div class="orders_index">
	<h2><?php echo __('Credit Card and Interact Transactions'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created', __('Date')); ?></th>							
			<th><?php echo $this->Paginator->sort('total'); ?></th>
			<th><?php echo $this->Paginator->sort('number'); ?></th>
			<th><?php echo $this->Paginator->sort('message'); ?></th>
			<th><?php echo $this->Paginator->sort('overall_status'); ?></th>
			<th><?php echo $this->Paginator->sort('order_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>	
			<th><?php echo $this->Paginator->sort('location_id', __('Restaurant')); ?></th>
	</tr>
	<?php 
	foreach ($transactionLogs as $transaction):
	?>

	<?php
	$class = 'info';
	switch ($this->ES->getValue($transaction, 'Order.overall_status')) {

		case 'accepted':
		case 'completed':
		case 'complete':
			$class = 'success';
		break;

		case 'rejected':
		case 'canceled':
			$class = 'error';
		break;
	}
	?>
	<tr class="<?php echo $class; ?>">
		<td>
			<?php echo h($transaction['TransactionLog']['id']); ?>
		</td>
		<td><?php echo $this->Date->formatDate($transaction['TransactionLog']['created']); ?>&nbsp;</td>						
		<td><?php echo $this->Currency->currency($transaction['Order']['total']); ?>&nbsp;</td>
		<td><?php echo h($transaction['TransactionLog']['number']); ?>&nbsp;</td>
		<td><?php echo h($transaction['TransactionLog']['message']); ?>&nbsp;</td>		
		<td><?php echo h($transaction['Order']['overall_status']); ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link('#'.$transaction['Order']['id'], array('controller'=>'orders', 'action' => 'admin_view', $transaction['Order']['id'])); ?>
		</td>
		
		<td>
			<?php echo $this->Html->link($this->ES->getValue($transaction, 'User.email'), array('controller' => 'users', 'action' => 'admin_view', $transaction['User']['id'])); ?>
		</td>
		
		<td>
			<?php echo $this->Html->link($this->ES->getValue($transaction, 'Location.name'), array('controller' => 'locations', 'action' => 'admin_view', $this->ES->getValue($transaction, 'Location.id'))); ?>
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
<?php
echo $this->Html->css('datepicker');
echo $this->Html->script('bootstrap-datepicker');
echo $this->Html->script('order_admin_index');
