<?php
echo $this->Form->create('Profile', array(
	'url' => array('controller' => 'profiles', 'action' => 'edit'),
	'id' => 'ProfileCheckoutForm',
	'inputDefaults' => array('div' => false),
	'default' => false));
?>
<div class="control-group">
	<?php
	echo $this->Form->input('Profile.first_name', array(
		'value' => $this->Session->read('Auth.Profile.last_name'),
		'div' => FALSE,
		'no_div' => TRUE));
	echo $this->Form->input('Profile.last_name', array(
		'value' => $this->Session->read('Auth.Profile.first_name'),
		'div' => FALSE,
		'no_div' => TRUE));
	?>
</div>

<?php
echo $this->Form->input(
	'Profile.language', array(
	'default' => $this->Session->read('Auth.User.language'),
	'options' => array(
		'en' => 'English',
		'fr' => 'Français')));
?>
<div class="control-group">
	<?php
	echo $this->Form->input(
		'User.password', array(
		'label' => __('Change Password?'),
		'autocomplete' => 'off',
		'value' => '',
		'div' => FALSE,
		'no_div' => TRUE,
		'placeholder' => __('Leave empty to keep password')));

	echo $this->Form->input(
		'User.password_confirm', array(
		'label' => __('Confirm Password'),
		'type' => 'password',
		'value' => '',
		'div' => FALSE,
		'no_div' => TRUE,
		'autocomplete' => 'off'
	));
	?>
</div>
<?php
echo $this->Form->input(
	'date_of_birth', array(
		'selected' => array(
			'year' => $this->Session->read('Auth.Profile.date_of_birth.year'), 
			'month' => $this->Session->read('Auth.Profile.date_of_birth.month'),
			'day' => $this->Session->read('Auth.Profile.date_of_birth.day')),
	'minYear' => date('Y') - 100,
	'maxYear' => date('Y')));
?>

<div id="proceed_to_payment" class="checkout_price">
	<?php
	echo $this->Form->submit(__('Confirm'), array(
		'class' => 'btn btn-success pull-right',
		'id' => 'contactInformationSubmitButton'));
	?>	
</div>

<?php
$this->Form->end();

