
<?php
echo $this->Session->flash('auth');
echo $this->Session->flash();
?>

<div class="login_box_one offset3 span5">
	<?php echo __('Password must have 8 characters and contain at least one uppercase and one lowercase letter.'); ?>	
	<br/>
	<br/>
	<?php echo $this->Form->create('User'); ?>

	<?php
	echo $this->Form->input('User.password', array(
		'label' => 'New Password'
	));
	echo $this->Form->input('User.password_confirm', array(
		'autocomplete' => 'off',
		'type' => 'password',
		'label' => 'Confirm Password'
	));
	?>

	<?php
	echo $this->Form->end(array(
		'style' => 'float:right;',
		'label' => __('Change Password'),
		'class' => 'btn btn-success'
	));
	?>	
</div>

<?php
//echo $this->element('password_meter');
$this->Html->script('password_meter', array('inline' => false));
