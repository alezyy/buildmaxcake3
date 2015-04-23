<div class="newsletters form span8">
<?php echo $this->Form->create('Newsletter'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Newsletter'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Newsletter.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Newsletter.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?></li>
	</ul>
</div>
