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
$this->Html->addCrumb(__('View Menu'), array(
	'controller' => 'menus',
	'action' => 'view',
	$location_id,
	$menu_id
));
$this->Html->addCrumb(__('Add Menu Category'));
?>
<div class="menuCategories form">
<?php echo $this->Form->create('MenuCategory', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Menu Category'); ?></legend>
	<?php
		echo $this->Image->input('image');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('description_en');
		echo $this->Form->input('description_fr');
		// echo $this->Form->input('start_time');
		// echo $this->Form->input('end_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>