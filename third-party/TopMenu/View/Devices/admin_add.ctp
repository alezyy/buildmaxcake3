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
$this->Html->addCrumb(__('Devices'), array(
	'controller' => 'devices',
	'action' => 'location_index',
	$location_id
));
$this->Html->addCrumb(__('Add Device'));
?>
<div class="devices form span10">
<?php echo $this->Form->create('Device'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Device'); ?></legend>
		<?php
		echo $this->Form->input('description');
		echo $this->Form->input(
			'timeout',
			array(
				'options' => array(
					'240' => __('4.0 min (WiFi)'),
					'390' => __('6.5 min (GSM)')
				)
			)
		);
		?>
	</fieldset>
	<?php 
	echo $this->Form->end(array(
		'label' => __('Submit'),
		'class' => 'btn btn-success pull-right',
		'style' => 'margin-bottom:10px;margin-right:20px;'
	));
	?>
</div>
