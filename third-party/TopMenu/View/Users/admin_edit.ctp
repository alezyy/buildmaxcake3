<?php
$this->Html->addCrumb(__('Users'), array(
	'controller' => 'users',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Edit User'));
?>
<div class="users form span10">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('password', array('value' => false));
		echo $this->Form->input('password_confirm', array('type' => 'password'));
		echo $this->Form->input('group_id');
		echo $this->Form->input('is_active');
		echo $this->Form->input('force_reset');
		echo $this->Form->input('Profile.first_name');
		echo $this->Form->input('Profile.last_name');
		echo $this->Form->input('Profile.phone');

		echo $this->Form->input('Location');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php
echo $this->element('password_meter');
echo $this->Html->script('password_meter', array('inline' => false));