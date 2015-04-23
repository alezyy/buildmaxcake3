<div class="orders index">
	<h2><?php echo __('Coupons'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>			
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>			
			<th><?php echo $this->Paginator->sort('offered_by', __('Offered by')); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			<th><?php echo $this->Paginator->sort('amount'); ?></th>
			<th><?php echo $this->Paginator->sort('is_enabled'); ?></th>
			<th><?php echo $this->Paginator->sort('max_usage', __('Coupons left')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($coupons as $coupon): ?>
	<tr class="<?php echo ($coupon['isInEffect']) ? 'success' : 'error'; ?>">
		<td><?php echo h($coupon['Coupon']['code']); ?>&nbsp;</td>
		<td><?php echo ($coupon['Coupon']['user_id']) ? h($coupon['Coupon']['user_id']) : __('ALL'); ?>&nbsp;</td>		
		<td><?php echo ($coupon['Coupon']['location_id'])? h($coupon['Coupon']['location_id']) : __('ALL'); ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['offered_by']?></td>
		<td><?php echo h($coupon['Coupon']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($coupon['Coupon']['end_date']); ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['amount'] . ' ' . (($coupon['Coupon']['amount_type'] === 'percent')? ' %' : ' $'); ?>&nbsp;</td>
		<td><?php echo h($coupon['Coupon']['is_enabled']); ?>&nbsp;</td>
		<td><?php echo (is_numeric($coupon['Coupon']['max_usage']) ? h($coupon['Coupon']['max_usage']) : '∞'); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coupon['Coupon']['id']), null, __('Are you sure you want to delete # %s?', $coupon['Coupon']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Coupon'), array('action' => 'add')); ?></li>
	</ul>
</div>
