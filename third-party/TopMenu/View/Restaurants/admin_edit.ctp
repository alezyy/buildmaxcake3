<?php
$this->Html->addCrumb(__('Restaurants'), array(
	'controller' => 'restaurants',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb($restaurant_name, array(
	'controller' => 'restaurants',
	'action' => 'view',
	$this->request->data['Restaurant']['id'],
	'admin' => true
));
$this->Html->addCrumb(__('Edit Restaurant'));
?>
<div class="restaurants form span8">
<?php echo $this->Form->create('Restaurant', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Restaurant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		
		echo $this->Image->input('logo');
		// echo $this->Form->input('Cuisine');
		// echo $this->Form->input('Specialty');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>