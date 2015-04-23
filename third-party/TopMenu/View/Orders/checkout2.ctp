<div class="container-white container">
	<div class="col-xs-12 col-md-7">
		<div class="accordion" id="checkout_left_side">
			
			
			<!-- DELIVERY DETAILS -->
			<div id="delivery_details_container" class="accordion-group">
			<?php echo $this->element('checkout/delivery_details'); ?>
			</div>
			
						
			<!-- PAYMENT METHOD -->
			<div class="accordion-group">
				<div class="checkout_header accordion-heading" id="billing_info">
					<div class="checkout_header_title"><?php echo __('Payment Method'); ?></div>
					
						<a class="accordion-toggle btn btn-danger pull-right" data-toggle="collapse" data-parent="#checkout_left_side" href="#edit_payment_method" role="button" id="payment_method_edit_button" style="display: none">
							<?php echo __('Edit'); ?>
						</a>
					<div class="checkout_header_description">
						<?php echo __('Please choose payment method'); ?>
					</div>
				</div>			
				<div class="checkout_edit_content accordion-body collapse in" id="edit_payment_method">
					<?php echo $this->Form->create('Payment', 
								array(
									'url' => array('controller' => 'orders', 'action' => 'proceed_to_payment'),
									'id' => 'proceedToPaymentForm',
									'default' => true,
									'inputDefaults' => array('div' => FALSE)));?>
					
					<div id="credit_or_cash">
						<?php						
											$timestamp   = time();  
         					         $currentHour = date('G', $timestamp);  	  				
						
					/**
               * Add by FA : 
               * After 22h topmenu doesn't accept credit card payment 
               *Restaurant centre des mets chinois doesn't accept cash payment. We will add a new backend functionality to remove the location ID here
               * It's temporary now ...
               */	
               			
if(($this->Session->read('Order.Order.type') === 'delivery') && ($currentHour >= 10 && $currentHour <= 21) && ($this->Session->read('Order.Order.location_id') == '528103b7-60b0-4bf7-b5e3-6a881ec880c8'))
               { 
       			 $optionsArray = array(
                         		'creditcard' =>$this->Html->image('checkout/Master_Card_Icon.png', array('alt' => 'Credit Card')) . '&nbsp;' .
							$this->Html->image('checkout/Visa_Payment_icon.png', array('alt' => 'Credit Card')),
											                   );
			      }
								
elseif (($this->Session->read('Order.Order.type') === 'delivery') && ($currentHour >= 10 && $currentHour <= 21)) {
       			 $optionsArray = array(
                         		'creditcard' =>$this->Html->image('checkout/Master_Card_Icon.png', array('alt' => 'Credit Card')) . '&nbsp;' .
							$this->Html->image('checkout/Visa_Payment_icon.png', array('alt' => 'Credit Card')),
								'cash' => __('CASH'));              
                              }						
																	
 elseif(($this->Session->read('Order.Order.type') === 'delivery') && ((($currentHour >= 22 && $currentHour <= 24)) || (($currentHour >= 0 && $currentHour <=9))) ) {
							$optionsArray = array(
								'cash' => __('CASH'));	
								}
								
elseif(($this->Session->read('Order.Order.type') === 'pickup') && ((($currentHour >= 22 && $currentHour <= 24)) || (($currentHour >= 0 && $currentHour <=9))) ){
							$optionsArray = array(
							'cash' => __('CASH'));						
							}
						else {
							$optionsArray = array(
				         	'creditcard' =>$this->Html->image('checkout/Master_Card_Icon.png', array('alt' => 'Credit Card')) . '&nbsp;' .
								$this->Html->image('checkout/Visa_Payment_icon.png', array('alt' => 'Credit Card')));
                  }
							
						echo $this->Form->radio(
							'Payment.method_of_payment', 
							$optionsArray,
							array(
								'legend' => FALSE,
								'class' => 'credit_or_cash_radio',
								'default' => $this->Session->read('Order.Order.method_of_payment')));
						?>
					</div>
					<div class="checkout_edit_content_inner">					
						<?php echo $this->Html->image('checkout/method_of_payment_border.png'); ?>                        										
						<div class="credit_or_cash_info" id="creditcard_info">
							<div class="control-group">
							<?php 
							echo $this->Form->input('Payment.credit_card.first_name', array(
								'label' => __('Name on Card'),
								'div' => false,
								'no_div' => true,
								'required' => 'required'));
							echo $this->Form->input('Payment.credit_card.last_name', 	array(
								'label' => __('First Name'),
								'div' => false,
								'no_div' => true));
							?>
								<div class="help-inline" style="display: none;"><?php echo __('Invalid credit card name'); ?></div>
							</div>
							
							<div class="control-group">
							<?php 
							echo $this->Form->input('Payment.credit_card.number', array(
								'type' => 'text',
								'label' => __('Credit Card No.'),
								'div' => false,
								'no_div' => true,
								'required' => 'required',
                                'onkeyup' => 'valid_credit_card(document.getElementById("PaymentCreditCardNumber").value)',
								'pattern' => Configure::read('regex.credit_card_number')));
							?>								
								<div class="help-inline" style="display: none;"><?php echo __('Invalid credit card number'); ?></div>
							</div>
							<div class="control-group">
								<?php
								echo $this->Form->input('Payment.credit_card.expire_month', array(
									'empty' => '--', 
									'required' => 'required',
									'label' => __('Expiry Date'),
									'div' => false,
									'no_div' => true,
									'style' => 'width: 60px; margin-right: 15px',
									'options' => array('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9', '10' => '10', '11' => '11', '12' => '12')));

								echo $this->Form->input('Payment.credit_card.expire_year', array(
									'empty' => '--', 
									'type' => 'date',
									'class' => 'span3',
									'div' => false,
									'no_div' => true,
									'style' => 'width: 60px; margin-right: 15px',
									'label' => FALSE,
									'dateFormat' => 'Y',
									'required' => 'required',
									'orderYear' => 'asc',
									'minYear' => date('y'),
									'after' => "<div class='help-inline' style='display: none;'>". __('Required') . "</div>",
									'maxYear' => date('y') + 30
								));								
								?>
								
								
							</div>

							<div class="control-group">
								<?php
								echo $this->Form->input('Payment.credit_card.cvv2', array(
									'label' => __('CVV NUMBER'),
                                    'type' => 'text',
									'div' => FALSE,
									'no_div' => TRUE,
									'style' => 'width: 48px; margin-right: 15px',
									'required' => 'required',
									'pattern' => Configure::read('regex.cvv2')));
								?>								
								<div class="help-inline" style="display: none;"><?php echo __('Invalid CVV2 number'); ?></div>
								<?php echo $this->Html->image('checkout/cvv.png'); ?>																
							</div>
                            
                            <div class="control-group">
								<?php
                                  echo $this->Form->input('Order.special_instruction_credit', array(
                                    'label' => __('Note'),
                                    'id' => 'OrderSpecialInstructionCredit',
                                    'type' => 'text',
                                    'div' => false,
                                    'no_div' => true,));
                                  ?>
                            </div>

							<?php echo $this->Form->hidden('Payment.billing_address.phone', array('id' => 'pbal1', 'value' => $this->Session->read('Order.Order.phone'))) ?>
							<?php echo $this->Form->hidden('Payment.billing_address.line1', array('id' => 'pbal1', 'value' => $this->Session->read('Order.Order.address'))) ?>
							<?php echo $this->Form->hidden('Payment.billing_address.line2', array('id' => 'pbal2', 'value' => $this->Session->read('Order.Order.address2'))) ?>
							<?php echo $this->Form->hidden('Payment.billing_address.city', array('id' => 'pbalc', 'value' => $this->Session->read('Order.Order.city'))) ?>
							<?php echo $this->Form->hidden('Payment.billing_address.postal_code', array('id' => 'pbalpc', 'value' => $this->Session->read('Order.Order.postal_code'))) ?>
							<?php echo $this->Form->hidden('Payment.billing_address.state', array('id' => 'pbalps', 'value' => $this->Session->read('Order.Order.province'))) ?>
							
							<?php echo $this->Form->hidden('Payment.return_urls.cancel_url', array('value' => 'cancelURL')) ?>
							<?php echo $this->Form->hidden('Payment.return_urls.return_url', array('value' => 'returnURL')) ?>
							
							<!--
							<?php echo $this->Form->hidden('Payment.transaction.id', array('value' => 'returnURL')) ?>
							<?php echo $this->Form->hidden('Payment.transaction.amount.currency', array('value' => 'returnURL')) ?>
							<?php echo $this->Form->hidden('Payment.transaction.amount.details.subtotal', array('value' => 'returnURL')) ?>
							<?php echo $this->Form->hidden('Payment.transaction.amount.details.tax', array('value' => 'returnURL')) ?>
							<?php echo $this->Form->hidden('Payment.transaction.amount.details.shipping', array('value' => 'returnURL')) ?>
							-->
							<?php echo $this->Form->end(); ?>
							

<!--							<div id="evo">
								<?php
								echo $this->Html->image('/img/checkout/evo.png', array(
									'alt' => __('Evo Payments International Canada')
								));
								?>
							</div>-->
							<div id="evo-side">
								<span class="strong">
									<?php echo __('Secure Payment Gateway: '); ?>
								</span>
								<?php echo __('All transactions are secured using SSL'); ?><br/>
								<?php echo __('encryption using GlobalSign certificate.'); ?>
							</div>
														
						</div>												
                        
                        <?php
                  
                        ?>
						<!-- This is only visible if the user chooses 'cash' as method of payment -->
						<div class="credit_or_cash_info" id="cash_info" style="display: none">		
                            <div class="control-group">
								<?php
                                  echo $this->Form->input('Order.special_instruction', array(
                                    'label' => __('Note'),
                                    'id' => 'OrderSpecialInstructionCash',
                                    'type' => 'text',
                                    'div' => false,
                                    'no_div' => true,));
                                  ?>
                            </div>
							<p class="red_centered">
								<?php echo __('Coupon can not be redeemed with cash order'); ?>
							</p>
						</div>					

						<div id="proceed_to_payment" class="checkout_price">
							
							<div class='alert alert-info left' id='checkout_notice'>
								<strong><?php echo __('Billing address'); ?></strong><br/>
								<span >
								<?php echo __('Please confirm that your billing address is the same as your credit card.'); ?>
								</span>
							</div>
							
							<span class="proceed_to_payment_label">
							<?php echo __('Total: '); ?>
							<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</span>
							<?php
							if($allowPayment):
							echo $this->Html->link(__('Place Order'), '', array(
								'class' =>  'btn btn-success',
								'role' => 'button',
								'id' => 'placeOrderLink'
							));
							else:
								echo $this->Form->button(__('Place Order'), array(
                                    'class' =>  'btn btn-success',
                                    'id' => 'placeOrderLink',
                                    'disabled' => 'disabled',
                                    'role' => 'button',
							));								
							endif;
							?>
							<br/>
							<div class="help-inline" id="pleaseChooseDeliveryAddress" style="display: none;"><?php echo __('Please Choose a delivery address'); ?></div>
							<div class="help-inline" id="pleaseChooseBillingAddress" style="display: none;"><?php echo __('Please Choose a billing address'); ?></div>
							<div class="small_text"> 
								<?php echo __('Fields mark with %s are required', "<span style='color:red'>*</span>"); ?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->end() ; ?>
				</div>
			</div>
		</div>
	</div>


<!-- ========================================= RIGHT SIDE ================================================ -->

	<div class="col-xs-12 col-md-5">
		<div class="accordion-heading" id="">
			<div class="checkout_header_title"><?php echo __('Your Order'); ?></div>
			<div class="checkout_header_button">
				<?php echo $this->Html->link(
					__('Add More Items'),
					array(
						'controller' => 'locations',
						'action' => 'view',
						'location' => $location['Location']['url'],
						'sector' => $location['Location']['sector_slug']),
					array(
						'class' => "accordion-toggle btn btn-success",
						"role" => "button"
						)
					); ?>				
			</div>
		</div>
		<div class="checkout_order_row">
			<div class="checkout_order_row_inner">
				<div id="checkout_logo">
					<?php echo $this->Image->out($location['Location']['logo'], '120x120', true, false, FALSE, array('width' => '100%')); ?>
				</div>
				<div id="checkout_restaurant_info">
					<p class="strong" style="margin-bottom: 0"><?php echo $location['Location']['name'] ?></p>
					<p class="weak" style="margin-bottom: 9px"><?php echo $location['Location']['short_address'] ?></p>
					<p style="margin-bottom: 10px">
						<?php echo ($this->Session->read('Order.Order.type') === 'delivery') ? __('Your order is for delivery') : __('Your order is for takeout'); ?>
					</p>					
					
					<!-- Delivery or Pickup radio Buttons -->
					<p class="checkbox">
						<?php if($this->Session->read('Order.Order.type') === 'delivery'): ?>
							<label class="radio-inline">
								<input type="radio" name="OrderType" value="delivery" checked/><?php echo __('Delivery'); ?>
							</label>
							<label class="radio-inline">
								<input type="radio" name="OrderType" value="pickup" onclick="javascript:window.location.href='<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'type' => 'pickup', 'language' => $langSuffix)); ?>'; return false;" /><?php echo __('Pickup'); ?>
							</label>
						<?php else: ?>
							<label class="radio-inline">
								<input type="radio" name="OrderType" value="delivery" onclick="javascript:window.location.href='<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'type' => 'delivery', 'language' => $langSuffix)); ?>'; return false;" /><?php echo __('Delivery'); ?>
							</label>
							<label class="radio-inline">
								<input type="radio" name="OrderType" value="pickup" checked /><?php echo __('Pickup'); ?>
							</label>
						<?php endif; ?>
					</p>

				</div>
			</div>
		</div>

		<div id="checkout_right_wrapper">
			<?php echo $this->element('checkout/checkout_right'); ?>		
		</div>
	</div>
	
	
</div>

<!-- ============================================= MODALS ================================================ -->  


<?php echo $this->element('checkout/confirmation_modal'); ?>


<!-- ============================================ JAVASCRIPT ============================================= -->

<script>
	
	/**
	 * Function called by ajax_submit_form.js if form submission is successful
	 * @param {object} currentForm A jQuery Form element that as been submited and receive a validation error free response
	 */
	function handleSuccessfulPost(currentForm){

		switch(currentForm.prop('id')){
			case 'ProfileCheckoutForm':
				
				// Change the content of the description bar for this section
				$('#checkout_header_description-contact_information').css('background-color','#f5faf3');
				$('#checkout_header_description-contact_information').css('color','#9ed882');
				$('#checkout_header_description-contact_information').css('font-size','14px');
				$('#checkout_header_description-contact_information').html('<?php echo __('Information Saved') ?>');
				
				// Collapse this section
				$('#contact_information_content').collapse('hide');
				$('#edit_payment_method').collapse('show');
				break;
				
			case 'DeliveryAddressUserEditForm':
				
				// Change the content of the description bar for this section
				$('#modalEditDeliveryAddress').modal('hide');	// close the modal form
				
				// Reload data
				var rowId = currentForm.find('#53689354809').val();
				var rowElement = $('#daRow_' + rowId);
				rowElement.find('.da_display_address').load('/delivery_addresses/display_one_address/' + rowId);	// relaod address text
				rowElement.effect("highlight");
				break;
				
			case 'DeliveryAddressCheckoutForm':
				window.location.href = '<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout')); ?>';
				break;
		}
	}
	
</script>

<!-- Javascript translations -->
<div style="display: none;">
	<span id="i18nCancel"><?php echo __('Cancel'); ?></span>
	<span id="i18nEdit"><?php echo __('Edit'); ?></span>
</div>
<?php
echo $this->Html->css('checkout', null, array('inline' => FALSE) );
echo $this->Html->script('checkout');
echo $this->Js->writeBuffer();
