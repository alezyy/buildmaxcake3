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
$this->Html->addCrumb(__('Add Menu Item'));
?>
<div class="menuItems form">
<?php echo $this->Form->create('MenuItem', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Menu Item'); ?></legend>
	<?php
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('description_en');
		echo $this->Form->input('description_fr');
		echo $this->Form->input('size_en');
		echo $this->Form->input('size_fr');
		echo $this->Form->input('no_price_text_en', array('type' => 'text'));
		echo $this->Form->input('no_price_text_fr', array('type' => 'text'));		
		echo $this->Form->input('price');
		echo $this->Image->input('image');
		echo $this->Form->input('icons');
		echo $this->Form->input('number_of_instance', array('value' => 1));
		echo $this->Form->input('MenuItemOption');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>