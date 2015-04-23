<div class="taxes form span10">
<?php echo $this->Form->create('Tax'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Tax'); ?></legend>
	<?php
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
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Taxes'), array('action' => 'index')); ?></li>
	</ul>
</div>
