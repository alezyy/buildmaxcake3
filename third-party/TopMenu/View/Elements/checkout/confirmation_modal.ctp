<?php echo $this->element('modal/header'); ?>
			<div class="modalConfirmation_header">
				<h3><?php echo __('Confirm Order'); ?></h3>
				<?php echo __('Check all the information and confirm your order'); ?>
			</div>
			<div class="confirmModalRow">
				<p class="strong"><?php echo __("Contact Information"); ?></p>
					<span class="tabs info_text" ><?php echo $this->Session->read('Auth.Profile.name'); ?></span>&emsp;
					<span class='info_text'><?php echo $this->Session->read('Auth.User.email'); ?></span>&emsp;
					<span class='info_text'><?php echo $this->Session->read('Order.Order.phone'); ?></span>
			</div>
			<div class="confirmModalRow">
                <p class="strong">
                    <?php echo __("Delivery Details"); ?>
                </p>
				<div class="confirmModalRowInner">
					<table class="confirmModalAddresses">
						<tr>							
				<?php if ($this->Session->read('Order.Order.type') === 'delivery'): ?>							
							<td>								
								<span class="strong uppercase" style="font-size: 15px"  id="modalBillingAddress0">
                                    <?php echo __('Delivery Address'); ?><br/>
                                </span>
								<span class="info_text">
                                    <?php
                                    $address2    = $this->Session->read('Order.Order.address2');
                                    $crossStreet = $this->Session->read('Order.Order.cross_street');
                                    ?>
                                    <?php echo $this->Session->read('Order.Order.address') ?>, 
                                    <?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
                                    <?php echo $this->Session->read('Order.Order.city') ?>&nbsp;
                                    (<?php echo $this->Session->read('Order.Order.province') ?>)<br/>
                                    <?php echo $this->Session->read('Order.Order.postal_code') ?><br/>
                                    <?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
								</span>								
							</td>                            
                            
                            <td id="modalBillingAddress1">								
								<span class="strong uppercase" style="font-size: 15px"><?php echo __('Billing Address'); ?></span><br/>
                                <div id="address_wrapper_bil_confirmation_modal" style="text-align: left">
                                    <span class="info_text">
                                        <?php $ba = $this->Session->read('BillingAddress'); ?>
                                        <?php if (!is_array($ba)): ?>  
                                            <?php echo __('Please add or choose one'); ?>
                                        <?php else: ?>
                                            <?php $address2 = $this->Session->read('BillingAddress.address2'); ?>
                                            <?php echo $this->Session->read('BillingAddress.address') ?>, 
                                            <?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
                                            <?php echo $this->Session->read('BillingAddress.city') ?>&nbsp;
                                            (<?php echo $this->Session->read('BillingAddress.province') ?>)<br/>
                                            <?php echo $this->Session->read('BillingAddress.postal_code') ?><br/>																					
                                        <?php endif; ?>
                                    </span>
								</div>						
							</td>
						<?php else: ?>
							<td>
							<span class="red"><?php echo __('Takeout order'); ?></span><br/>
							<?php echo __('Your phone number: ') ?><?php echo $this->Session->read('Order.Order.phone'); ?><br/>
							</td>
						<?php endif; ?>
						</tr>
					</table>
							
				</div>
			</div>
			
			<div id="terms_and_agreements">
				<div id="terms_checkbox_container">
					<input type="checkbox" checked="checked" id="terms_checkbox"/>
				</div>
				<div id="terms_text_link">
					<?php echo $this->Html->link(__("By selecting this check box I agree to Topmenu's Terms & Conditions"), 
						array(
							'controller' => 'pages',
							'action' => 'terms'),
						array('target' => '_blank', 'escape' => false)); ?>					
				</div>
			</div>
			
			<div id="proceed_to_payment" class="checkout_price">
				<span class="proceed_to_payment_label">
				<?php echo __('Total: '); ?>
				<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
				</span>
				<?php
				echo $this->Form->button(__('Place Order'), 
					array(
						'id' => 'modalConfirmationPlaceOrder',
						'class' => 'btn btn-success',
						'role' => 'button',
						'style' => 'margin-left: 20px',
						'data-toggle' => "modal",
				));
				?>
			</div>

<script>
    
    // Hide billing address if order is cash
    // damn using to post data to the server is annoying
    $('#modalConfirmation').on('show', function(){
        $.ajax({
            url: '/app/read_session/Order.Order.method_of_payment',            
        }).done(function(msg) {
            if(msg !== 'creditcard' && msg !== '"creditcard"')  {
                $('#modalBillingAddress0').hide();
                $('#modalBillingAddress1').hide();
            }else{
                $('#modalBillingAddress0').show();
                $('#modalBillingAddress1').show();
            }
        });
    });

</script>
<?php echo $this->element('modal/footer'); ?>