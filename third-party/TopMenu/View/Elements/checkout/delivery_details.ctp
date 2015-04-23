
	<div class="checkout_header accordion-heading" id="delivery_information">
		<div class="checkout_header_title">
			<?php echo ($this->Session->read('Order.Order.type') === 'delivery') ? __('Delivery Details') : __('Billing Address'); ?>
		</div>
		
			<a class="accordion-toggle btn btn-default pull-right" data-toggle="collapse" data-parent="#checkout_left_side" href="#contact_delivery_details" role="button">
				<i class="ion-edit"></i> <?php echo __('Edit'); ?>
			</a>
		<div class="checkout_header_description">
			<?php if ($this->Session->read('Order.Order.type') === 'delivery'): ?>
				<div class="left">
					<span class="strong uppercase"><?php echo __('Delivery Address'); ?></span><br/>
						<div id="address_wrapper_del">
						<?php
						$address2 = $this->Session->read('Order.Order.address2');
						$crossStreet = $this->Session->read('Order.Order.cross_street');
						?>
						<?php echo $this->Session->read('Order.Order.address') ?>, 
						<?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
						<?php echo $this->Session->read('Order.Order.city') ?>&nbsp;
						(<?php echo $this->Session->read('Order.Order.province') ?>)<br/>
						<?php echo $this->Session->read('Order.Order.postal_code') ?><br/>
						<?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
						</div>
				</div>
				<div class="left">
					<span class="strong uppercase"><?php echo __('Billing Address'); ?></span><br/>
						<div id="address_wrapper_bil">
						<?php
						$address2 = $this->Session->read('BillingAddress.address2');
						?>
						<span><?php echo $this->Session->read('BillingAddress.address') ?>, 
						<?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
						<?php echo $this->Session->read('BillingAddress.city') ?>&nbsp;
						(<?php echo $this->Session->read('BillingAddress.province') ?>)<br/>
						<?php echo $this->Session->read('BillingAddress.postal_code') ?><br/>
						</div>
				</div>
			<?php else: ?>
				<span class="red"><?php echo __('Takeout order'); ?></span><br/>
				<?php echo __('Your phone number: ') ?><?php echo $this->Session->read('Order.Order.phone'); ?><br/>
			<?php endif; ?>
		</div>
	</div>
	<div class="checkout_edit_content accordion-body collapse" id="contact_delivery_details">
		<div class="checkout_edit_content_inner">

			<?php echo $this->Form->create(); ?>
			<table id="addresses_matrix">
				<tr>
				<thead>
				<th></th>
				<th></th>
				<?php if ($this->Session->read('Order.Order.type') === 'delivery'): ?>
				<th class="readiobuttoncell"><?php echo __('Delivery Address'); ?></th>
				<th class="readiobuttoncell"><?php echo __('Billing Address'); ?></th>
				<?php else: ?>
				<th class="readiobuttoncell" style="width: 310px"><?php echo __('Billing Address'); ?></th>
				<?php endif; ?>
				</thead>
				<tbody>
					<?php foreach ($deliveryAddresses as $da): ?>
						<tr id="daRow_<?php echo $da['DeliveryAddress']['id'] ?>">
							<td class="da_display_address">
								<?php if ($da['DeliveryAddress']['name']): ?>
									<span class="strong uppercase"><?php echo $da['DeliveryAddress']['name']; ?></span><br/>
								<?php endif; ?>

								<?php
								$address2 = $da['DeliveryAddress']['address2'];
								$crossStreet = $da['DeliveryAddress']['cross_street'];
								?>
									<span id="ool1_<?php echo $da['DeliveryAddress']['id']; ?>"><?php echo $da['DeliveryAddress']['address'] ?></span>, 
								<span id="ool2_<?php echo $da['DeliveryAddress']['id']; ?>"><?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?></span>
								<span id="ooc_<?php echo $da['DeliveryAddress']['id']; ?>"><?php echo $da['DeliveryAddress']['city'] ?></span>&nbsp;
								(<span id="oop_<?php echo $da['DeliveryAddress']['id']; ?>"><?php echo $da['DeliveryAddress']['province'] ?></span>)<br/>
								<span id="oopc_<?php echo $da['DeliveryAddress']['id']; ?>"><?php echo $da['DeliveryAddress']['postal_code'] ?></span><br/>
								<?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
							</td>
							<td class="bottom">
								<?php
								echo $this->Html->link(__('Edit'), array('controller' => 'deliveryAddresses', 'action' => 'user_edit', $da['DeliveryAddress']['id']), array('class' => 'edit_link green', 'id' => $da['DeliveryAddress']['id']));
								?>
								<br/>
								<?php
								echo $this->Html->link(__('Delete'), array('controller' => 'deliveryAddresses', 'action' => 'delete_confirm', $da['DeliveryAddress']['id']), array('class' => 'delete_link delete', 'id' => $da['DeliveryAddress']['id']));
								?>
							</td>
								<?php if ($this->Session->read('Order.Order.type') === 'delivery'): ?>
									<?php if ($da['DeliveryAddress']['available']): ?>
									<td class="readiobuttoncell">
										<?php echo $this->Form->radio('delivery', 
														array($da['DeliveryAddress']['id'] => ''),
														array(
															'label' => false,
															'legend' => false,
															'checked' => ($da['DeliveryAddress']['id'] === $this->Session->read('Order.Order.address_id')) ? 'checked' : 'false',
															'value' => false)); 
												?>
									</td>
									<?php else: ?>
									<td class="readiobuttoncell" style="font-style: italic; font-size: 10px; ">
										<?php echo __('The restaurant does not delivery to this addresss') ?>
									</td>
									<?php endif; ?>
								<?php endif; ?>
								<td class="readiobuttoncell">
									<?php echo $this->Form->radio('billing', 
													array($da['DeliveryAddress']['id'] => ''),
													array(
														'label' => false,
														'legend' => false,
														'checked' => ($da['DeliveryAddress']['id'] === $this->Session->read('BillingAddress.id')) ? 'checked' : 'false',
														'value' => false)); 
											?>
								</td>
							
						</tr>
							<?php endforeach; ?>
				</tbody>
			</table>
			<?php echo $this->Form->end(); ?>
		</div>
		
		<!-- ADD NEW ADDRESS FORM -->
		<div id="add_addresse_form">			
				<?php echo $this->element('add_delivery_address_form'); ?>					
		</div>						

	</div>

<!-- Modal Edit form --> 

<div id="modalEditDeliveryAddress"  class="modal hide fade modalCustom" tabindex="-1" role="dialog" aria-labelledby="modalConfirmation" aria-hidden="true">
	<button class="close_button" data-dismiss="modal" aria-hidden="true">
<?php echo $this->Html->image('checkout/modal_close_button.png', array('id' => 'modal_close_button')); ?>
	</button>
	<div class="modal-border">
		<div class="modalConfirmation_inner">
			<div class="modalConfirmation_header">
				<h3><?php echo __('Edit address'); ?></h3>
			</div>
			<div id="modalDeliveryAddressContent" class="confirmModalRow">

			</div>
			<table style="width: 100%; padding-top: 40px;"><tr><td>&nbsp;</td></tr></table> <!-- only to force div height -->
		</div>
	</div>
</div>


<div id="modalDeleteDeliveryAddress"  class="modal hide fade modalCustom" tabindex="-1" role="dialog" aria-labelledby="modalConfirmation" aria-hidden="true">
	<button class="close_button" data-dismiss="modal" aria-hidden="true">
<?php echo $this->Html->image('checkout/modal_close_button.png', array('id' => 'modal_close_button')); ?>
	</button>
	<div class="modal-border">
		<div class="modalConfirmation_inner">
			<div class="modalConfirmation_header">
				<h3><?php echo __('Delete this address?'); ?></h3>
			</div>
			<div id="modalDeleteDeliveryAddressContent" class="confirmModalRow">

			</div>
			<table style="width: 100%; padding-top: 40px;"><tr><td>&nbsp;</td></tr></table> <!-- only to force div height -->
		</div>
	</div>
</div>



<!-- Script for the edit and delete button inside the delivery address matrix -->
<script type="text/javascript">

	/**
	 * Edit Address link
	 */
	$('.edit_link').click(function(event) {

		// Get the html for the modal form
		$('#modalDeliveryAddressContent').load($(this).prop('href'));

		// Display modal
		$('#modalEditDeliveryAddress').modal('show');

		event.preventDefault();
	});

	/**
	 * Delete Address link
	 */
	$('.delete_link').click(function(event) {

		// Get the html for the modal form
		$('#modalDeleteDeliveryAddressContent').load($(this).prop('href'));

		// Display modal
		$('#modalDeleteDeliveryAddress').modal('show');

		event.preventDefault();
	});

</script>