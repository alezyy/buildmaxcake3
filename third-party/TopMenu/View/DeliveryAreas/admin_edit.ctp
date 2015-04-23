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
$this->Html->addCrumb(__('View Delivery Areas'), array(
	'controller' => 'delivery_areas',
	'action' => 'view',
	$location_id,
	$this->request->data['DeliveryArea']['id']
));


$this->Html->addCrumb(__('Edit Delivery Area'));
?>
<div class="deliveryAreas form span10">
<?php echo $this->Form->create('DeliveryArea'); ?>
	<fieldset>
		<legend><?php echo __('Edit Delivery Area'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input(
			'postal_code',
			array(
				'style' => 'text-transform: uppercase;'
			)
		);
		echo $this->Form->input(
			'delivery_charge',
			array(
				'prepend' => '$'
			)
		);
		echo $this->Form->input(
			'delivery_min',
			array(
				'prepend' => '$'
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
