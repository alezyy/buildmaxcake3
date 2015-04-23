<?php
$this->Html->addCrumb(__('Orders'), array(
	'controller' => 'orders',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Order'), array(
	'controller' => 'orders',
	'action' => 'view',
	$this->Form->value('Order.id')
));
$this->Html->addCrumb(__('Edit Order'));
?>
<div class="orders form span10">
<br/>
<h1><?php echo __('Admin Edit Order'); ?></h1>
<br/>
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Order Number'); ?></legend>
	<?php echo $this->Form->input('id', array('type' => 'text', 'readonly' => 'readonly')); ?>
	<legend><?php echo __('Charges'); ?></legend>
	<?php		
		echo $this->Form->input('delivery_charge');
		echo $this->Form->input('subtotal', array('label' => __('Food')));		
		echo $this->Form->input('coupon_discount');		
		echo $this->Form->input('gst');
		echo $this->Form->input('pst');
		echo $this->Form->input('tip');
		echo $this->Form->input('total');
	?>		
	<legend><?php echo __('Status'); ?></legend>
	<?php
        $mop = array('cash' => __('Cash'), 'creditcard' => __('Credit Card'));
		echo $this->Form->input('method_of_payment', array('options' => $mop));
		echo $this->Form->input('gateway_status', array('readonly' => 'readonly'));
		echo $this->Form->input('device_status', array(
			'options' => array('accepted' => __('Accepted'), 'timeout' => __('Timeout'), 'rejected' => __('Rejected'), 'waiting_resto' => __('waiting_resto'))
		));
		echo $this->Form->input('overall_status', array(
			'options' => array('complete' => __('Completed'), 'processing' => __('Processing'), 'rejected' => __('Rejected'), 'DELETED' => __('Deleted'))
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
