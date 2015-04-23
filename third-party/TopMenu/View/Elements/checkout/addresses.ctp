<div class="row">	
	<?php if ($this->Session->read('Order.Order.type') == 'delivery'): ?>
		<div class="col-xs-12 col-md-6">
			<?php 
				echo $this->Form->create('DeliveryAddress', ['action' => 'change_delivery_address', 'id' => 'deliveryAddressForm']);

					echo $this->Form->input('delivery_address', 
						[
							'label' => __('Delivery Address'),
					      	'options' => $deliveryAddresses,
					      	'selected' => $currentAddress,
					      	'class' => 'form-control'
						]
					); 

				echo $this->Form->end();
			?>
		</div>
	<?php endif ?>
	<div class="col-md-6">
		<?php 
			echo $this->Form->create('DeliveryAddress', ['action' => 'change_billing_address', 'id' => 'billingAddressForm']);

				echo $this->Form->input('billing_address',
					[
						'label' => __('Billing Address'),
				      	'options' => $deliveryAddresses,
				      	'selected' => $currentAddress,
				      	'class' => 'form-control'
					]
				); 

			echo $this->Form->end();
		?>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-xs-12">

	<div id="deliveryAddress" class="col-md-6">
		<?php if ($this->Session->read('DeliveryDestination.id')):
			$deliveryAddress = $this->Session->read('DeliveryDestination'); ?>
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
		<?php endif; ?>
	</div>

	<div id="billingAddress" class="col-md-6">
		<?php if ($this->Session->read('BillingAddress.id')):
			$billingAddress = $this->Session->read('BillingAddress'); ?>
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
		<?php endif; ?>
	</div>
</div>