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
$this->Html->addCrumb(__('Delivery Areas'));

?>
<div class="deliveryAreas index span10">
	<h2><?php echo __('Delivery Areas'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('postal_code'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_charge'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_min', __('Delivery Minimum')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($deliveryAreas as $deliveryArea): ?>
	<tr>
		<td>
			<?php
			echo $this->Html->link(
				$deliveryArea['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$deliveryArea['Location']['id']
					)
			);
			?>
		</td>
		<td><?php echo h($deliveryArea['DeliveryArea']['postal_code']); ?>&nbsp;</td>
		<td><?php echo $this->Currency->currency($deliveryArea['DeliveryArea']['delivery_charge']); ?>&nbsp;</td>
		<td><?php echo $this->Currency->currency($deliveryArea['DeliveryArea']['delivery_min']); ?>&nbsp;</td>
		<td class="actions">
			<?php
			echo $this->Html->link(
				__('Edit'),
				array('action' => 'edit', $location_id, $deliveryArea['DeliveryArea']['id'])
			);
			?>
			&nbsp;
			<?php
			echo $this->Form->postLink(
				__('Delete'),
				array(
					'action' => 'delete',
					$location_id,
					$deliveryArea['DeliveryArea']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $deliveryArea['DeliveryArea']['id'])
			);
			?>
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
		<li>
			<?php
			echo $this->Html->link(
				__('New Delivery Area'),
				array('action' => 'add', $location_id)
			);
			?>
		</li>
	</ul>
</div>
