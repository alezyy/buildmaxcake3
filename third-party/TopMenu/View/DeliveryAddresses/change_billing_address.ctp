<?php echo $billingAddress['address'] ?><br/>
<?php if ($billingAddress['address2'] != ""): ?>
	<?php echo $billingAddress['address2'] ?><br/>
<?php endif ?>
<?php echo ucfirst($billingAddress['city']) ?><br/>
<?php echo ucfirst($billingAddress['province']) ?><br/>
<?php echo strtoupper($billingAddress['postal_code']) ?><br/>
<?php echo $this->Html->link(_('Edit address'), 
	array(
		'controller' => 'deliveryAddresses', 
		'action' => 'user_edit', 
		$billingAddress['id']
	),
	array(
		'class'	=> 'btn btn-default btn-xs'
	)
); ?>
