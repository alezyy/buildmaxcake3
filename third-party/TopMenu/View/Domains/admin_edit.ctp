<?php
$this->Html->addCrumb(__('Restaurants'), array(
	'controller' => 'restaurants',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(
	$restaurant_name,
	array(
		'controller' => 'restaurants',
		'action'     => 'view',
		'admin'      => true,
		$restaurant_id
	)
);
$this->Html->addCrumb(__('Domains'), array(
	'controller' => 'domains',
	'action' => 'index',
	$restaurant_id,
));
$this->Html->addCrumb(__('View Domain'), array(
	'controller' => 'domains',
	'action' => 'view',
	$restaurant_id,
	$this->Form->value('Domain.id')
));
$this->Html->addCrumb(__('Edit Domain'));
?>
<div class="domains form span10">
<?php echo $this->Form->create('Domain'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Domain'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('domain_type');
		echo $this->Form->input('domain_name');
		echo $this->Form->input('main_website');
		echo $this->Form->input('theme_id');
		echo $this->Form->input('theme_values');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>