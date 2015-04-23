<?php echo $deliveryAddress['address'] ?><br/>
<?php if ($deliveryAddress['address2'] != ""): ?>
	<?php echo $deliveryAddress['address2'] ?><br/>
<?php endif ?>
<?php echo ucfirst($deliveryAddress['city']) ?><br/>
<?php echo ucfirst($deliveryAddress['province']) ?><br/>
<?php echo strtoupper($deliveryAddress['postal_code']) ?><br/>
<?php echo $this->Html->link(_('Edit address'), 
	array(
		'controller' => 'deliveryAddresses', 
		'action' => 'user_edit', 
		$deliveryAddress['id']
	),
	array(
		'class'	=> 'btn btn-default btn-xs'
	)
); ?>