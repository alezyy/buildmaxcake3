<div class="newsletters form span8">
<?php echo $this->Form->create('Newsletter'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Newsletter'); ?></legend>
	<?php
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('telephone');
		echo $this->Form->input('email');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('postal_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?></li>
	</ul>
</div>
