<?php // change the header if an order is in session    ?>
<?php if ($this->Session->check('Order.Order')): ?>
	<?php
	$this->assign('mobile_header_block', $this->element(
			'mobile/checkout_header', array(
			'title' => __('Billing Address'),
			'alt' => __('Back to payment page'),
			'href' => Router::url(array('controller' => 'payments', 'action' => 'billing_info')))));
	?>

<?php endif; ?>
<div class="row_mobile centered-row row">
	<?php
	$address2 = $this->Session->read('Order.Order.address2');
	$crossStreet = $this->Session->read('Order.Order.cross_street');
	?>
	<?php echo $this->Session->read('Order.Order.address') ?>, 
	<?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
	<?php echo $this->Session->read('Order.Order.city') ?>
	(<?php echo $this->Session->read('Order.Order.province') ?>)
	<p><?php echo $this->Session->read('Order.Order.postal_code') ?></p>
	<?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
</div>

<div class="button-row row row_emphasis">
	<?php
	echo $this->Html->link(
		__('Order to this address'), array('controller' => 'delivery_addresses', 'action' => 'same_as_delivery'), array(
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
	<?php echo $this->Form->input('phone', array('type' => 'hidden', 'value' => 'billing')); ?>
	<?php echo $this->Form->input('address', array('placeholder' => __('Address *'))); ?>
	<?php echo $this->Form->input('address2', array('placeholder' => __('Address 2'))); ?>
	<?php echo $this->Form->input('city', array('placeholder' => __('City *'))); ?>
	<?php echo $this->Form->input('postal_code', array('placeholder' => __('Postal Code *'))); ?>
	<?php echo $this->Form->input('province', array('placeholder' => __('Province *'))); ?>
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
<table style="width: 100%"><tr><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td></tr></table>

<?php
echo $this->Html->script('confirm');
echo $this->Html->css('confirm', null, array('inline' => FALSE));