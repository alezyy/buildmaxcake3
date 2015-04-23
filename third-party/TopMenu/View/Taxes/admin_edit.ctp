<?php
$this->Html->addCrumb(__('Taxes'), array(
	'controller' => 'taxes',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Edit Tax'));
?>
<div class="taxes form span10">
<?php echo $this->Form->create('Tax'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Tax'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('country');
		echo $this->Form->input('province');
		echo $this->Form->input('percentage');
		echo $this->Form->input('is_compound');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>