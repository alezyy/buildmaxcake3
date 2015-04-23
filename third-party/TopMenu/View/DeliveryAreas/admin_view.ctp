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
$this->Html->addCrumb(__('Delivery Areas'), array(
	'controller' => 'delivery_areas',
	'action' => 'index',
	$location_id
));
$this->Html->addCrumb(__('View Delivery Areas'));
?>
<div class="deliveryAreas view span10">
<h2><?php echo __('Delivery Area'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deliveryArea['DeliveryArea']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php
			echo $this->Html->link(
				$deliveryArea['Location']['name'],
				array('controller' => 'locations', 'action' => 'view', $deliveryArea['Location']['id'])
			);
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($deliveryArea['DeliveryArea']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery Charge'); ?></dt>
		<dd>
			<?php echo h($deliveryArea['DeliveryArea']['delivery_charge']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li>
			<?php
			echo $this->Html->link(
				__('Edit Delivery Area'),
				array('action' => 'edit', $location_id, $deliveryArea['DeliveryArea']['id'])
			);
			?>
		</li>
		<li>
			<?php
			echo $this->Form->postLink(
				__('Delete Delivery Area'),
				array(
					'action' => 'delete',
					$location_id,
					$deliveryArea['DeliveryArea']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $deliveryArea['DeliveryArea']['id'])
			);
			?>
		</li>
	</ul>
</div>
