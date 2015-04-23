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
$this->Html->addCrumb(__('Edit Device'));
?>
<div class="devices  span10">
<?php echo $this->Form->create('Device'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Device'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
<div class="actions span2">
	<ul class="nav nav-tabs nav-stacked">
		<li>
			<?php
			echo $this->Form->postLink(
				__('Delete Device'),
				array(
					'action' => 'delete',
					$location_id,
					$this->Form->value('Device.id')
				),
				array(
					'style' => 'min-width:115px; margin-bottom:5px'
				),
				__(
					'Are you sure you want to delete %s?',
					$this->Form->value('Device.description')
				)
			);
			?>
		</li>
		<li>
			<?php
			echo $this->Form->postLink(
				__('Generate New Credentials'),
				array(
					'action' => 'generate_new_credentials',
					$location_id,
					$this->Form->value('Device.id')
				),
				array(
				),
				__(
					'Are you sure you want to generate new credentials for %s? This will invalidate the old credentials.',
					$this->Form->value('Device.description')
				)
			);
			?>
		</li>
	</ul>
</div>
<div class="span2">
	
</div>