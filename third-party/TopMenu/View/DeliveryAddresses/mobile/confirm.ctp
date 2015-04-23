<?php // change the header if an order is in session    ?>
<?php if ($this->Session->check('Order.Order')): ?>
	<?php
	$this->assign('mobile_header_block', $this->element(
			'mobile/checkout_header', array(
			'title' => __('Address Confirmation'),
			'alt' => __('Back to menu page'),
			'href' => Router::url(array('controller' => 'orders', 'action' => 'checkout')))));
	?>

<?php endif; ?>
<?php // show the restaurant inforamtion row (the element does the checks for an order in session) ?>
<?php echo $this->element('/mobile/restaurant_info_row', array('add_botom_border' => '')); ?>

<div class="trait row">
	<div class="trait strong">
		<?php echo $this->Html->image('mobile/fancy-border.png', array('class' => 'trait-left', 'div' => FALSE)); ?>
		<?php echo __('Confirm Mobile Number'); ?>
		<?php echo $this->Html->image('mobile/fancy-border.png', array('class' => 'trait-right')); ?>
	</div>
</div>

<div class="row">
	<div class="four-gray-border">
		<?php echo $this->Session->read('Order.Order.phone'); ?>
	</div>
</div>

<div class="trait row">
	<div class="trait strong">
		<?php echo $this->Html->image('mobile/fancy-border.png', array('class' => 'trait-left')); ?>
		<?php echo __('Delivery Address'); ?>
		<?php echo $this->Html->image('mobile/fancy-border.png', array('class' => 'trait-right')); ?>
	</div>
</div>

<div class="centered-row row">
	<?php
	$address2 = $this->Session->read('Order.Order.address2');
	$crossStreet = $this->Session->read('Order.Order.cross_street');
	?>
	<?php echo $this->Session->read('Order.Order.address') ?>, 
	<?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
	<?php echo $this->Session->read('Order.Order.city') ?>
	(<?php echo $this->Session->read('Order.Order.province') ?>)
	&nbsp;<?php echo $this->Session->read('Order.Order.postal_code') ?><br/>
	<?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
</div>

<div class="button-row row row_emphasis">
	<?php
	echo $this->Html->link(
		__('Order to this address'), array('controller' => 'orders', 'action' => 'checkout'), array(
		'class' => 'btn btn-success',
		'rel' => 'nofollow',
		'role' => 'button'));
	?>
</div>

<div class="row" style="height: 40px">&nbsp;</div>

<div class="row_mobile row row_emphasis form-row">
	<div id="newAddressClickable">
		<a id="newAddressTitle" class="green-text strong" style="padding: 15px 0;"><?php echo __('+ ADD NEW ADDRESS'); ?></a>
	</div>
	<div id="newAddressForm" style="display: none; margin-top: 15px">
	<?php
	echo $this->Form->create('DeliveryAddress', array(
		'inputDefaults' => array('no_div' => true, 'div' => false, 'label' => false)));
	?>
	<?php echo $this->Form->input('name', array('placeholder' => __('Address Label'))); ?>
	<?php echo $this->Form->input('phone', array('type' => 'phone', 'placeholder' => __('Phone *'))); ?>
	<?php echo $this->Form->input('address', array('placeholder' => __('Address *'))); ?>
	<?php echo $this->Form->input('address2', array('placeholder' => __('Address 2'))); ?>
	<?php echo $this->Form->input('city', array('placeholder' => __('City *'))); ?>
	<?php echo $this->Form->input('postal_code', array('placeholder' => __('Postal Code *'))); ?>
	<?php echo $this->Form->hidden('province', array('value' => 'Quebec')); ?>
	<?php
	echo $this->Html->link($this->Html->image('BOUTONS/plus-sign.png') . ' ' . __('Order to this addresss'), '', array(
		'id' => 'DeliveryAddressConfirmFormSubmitButton',
		'role' => 'button',
		'escape' => false,
		'rel' => 'nofollow',
		'class' => 'btn btn-success'));
	?>
	<?php echo $this->Form->end(); ?>
	</div>
</div>

<?php 
echo $this->Html->script('confirm');
echo $this->Html->css('confirm', null, array('inline' => FALSE));