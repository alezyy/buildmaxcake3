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
$this->Html->addCrumb(__('Menus'), array(
	'controller' => 'menus',
	'action' => 'index',
	$location_id
));
$this->Html->addCrumb(__('Add Menu'));
?>
<div class="menus form span8">
<?php echo $this->Form->create('Menu'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Menu'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input(
			'status',
			array(
				'options' => array(
					'active' => __('Active'),
					'inactive' => __('Inactive')
				)
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
