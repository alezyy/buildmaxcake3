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
$this->Html->addCrumb(__('Edit Options'), array(
	'controller' => 'menu_item_options',
	'action' => 'index',
	$location_id,
	$menu_id,
	$category_id
));
$this->Html->addCrumb(__('Edit Option'));
?>
<div class="menuItemOptions form">
<?php echo $this->Form->create('MenuItemOption'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Menu Item Option'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('description');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('multiselect');
		echo $this->Form->input('required');
		echo $this->Form->input('number_of_free_values');
		echo $this->Form->input('half_and_half');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>