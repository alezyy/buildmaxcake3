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
$this->Html->addCrumb(__('Add Delivery Area'));
?>
<div class="deliveryAreas form span10">
<?php echo $this->Form->create('DeliveryArea'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Delivery Area'); ?></legend>
	<?php
		echo $this->Form->input(
			'postal_code',
			array(
				'style' => 'text-transform: uppercase;'
			)
		);
		echo $this->Form->input('delivery_charge');
		echo $this->Form->input('delivery_min');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
