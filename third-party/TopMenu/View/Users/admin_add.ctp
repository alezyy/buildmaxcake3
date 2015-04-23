<?php
$this->Html->addCrumb(__('Users'), array(
	'controller' => 'users',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Add User'));
?>
<div class="users form span8">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('password_confirm', array('type' => 'password'));
		echo $this->Form->input('group_id');
		echo $this->Form->input('is_active');
		echo $this->Form->input('force_reset');
		echo $this->Form->input('Profile.first_name');
		echo $this->Form->input('Profile.last_name');
		echo $this->Form->input('Profile.phone');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php
echo $this->element('password_meter');
echo $this->Html->script('password_meter', array('inline' => false));