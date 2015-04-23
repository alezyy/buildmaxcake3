<div class="specialties form span10">
<?php echo $this->Form->create('Specialty', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Specialty'); ?></legend>
	<?php
		echo $this->Form->input('name_fr');
		echo $this->Form->input('name_en');
		echo $this->Image->input('image');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Specialties'), array('action' => 'index')); ?></li>
	</ul>
</div>
