	<?php $i = 0; ?>
	<?php $oodArray = $this->Session->read('Order.OrderDetail'); ?>
	<?php $oodlenght = count($this->Session->read('Order.OrderDetail')); ?>
	<?php $odArray = $this->Session->read('Order.OrderDetail'); ?>
	<?php if(empty($odArray)): ?>
	<div class="checkout_order_row item">	
		<div class="checkout_order_row_inner">
			<h3><?php echo __('Your order is empty.'); ?></h3>
			<?php echo $this->Html->link(
					__('Back to menu'),
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
	<?php else: ?>
		<div class="accordion" id="items_details">
			
			<!-- --------------------------------------------------------------------------------------  ITEMS LIST  -->
							
			<?php foreach ($this->Session->read('Order.OrderDetail') as $key => $od): ?>			
				<?php $i++ ?>		
				<div class="checkout_order_row item">	
					<div class="checkout_order_row_inner">
						<div class="checkout_detail">

							<!-- COLLAPSABLE START -->
							<div class="accordion-group">
								<!-- COLLAPSABLE HEADING -->								
								<div class="accordion-heading">	
									<div class="left"><p class="strong"><?php echo $od['name'] ?></p></div>
									<?php if (!empty($od['description']) || !empty($od['options'])): ?>
										<div class="right">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#items_details" href="#item_<?php echo $i; ?>">
												<?php echo $this->Html->image('checkout/expand.png', array('alt' => 'details', 'style' => 'display: inline-block')); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>

								<!-- COLLAPSABLE BODY -->
								<div class="item_detail accordion-body collapse" id="item_<?php echo $i; ?>">
									<p>
										<?php echo $od['description'] ?>
									</p>
									<?php if (!empty($od['options'])) : ?>
										<p>
											<?php echo __('Options') ?>
										</p>											
										<table class="embedTable">
											<?php foreach ($od['options'] as $o) : ?>
												<tr>
													<td>
														<?php echo $o['quantity'] ?> X
													</td>
													<td>
														<?php echo $o['name'] ?>
													</td>														
													<td class="nowrap">
														<?php echo $this->Number->currency($o['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</table>
									<?php endif; ?>


								</div>
							</div>
							<!-- END COLLAPSABLE -->


							<div class="bottom">
								<div class="left">										
									<?php echo $this->Html->link(
										$this->Html->image('checkout/minus-sign.png', array('alt' => __('add one'))),
										array("controller" => "orders", "action" => "decrement_item_quantity", $key),
										array('escape' => false, 'class' => 'decrement-item', 'rel' => 'nofollow', 'data-qty' => $od['quantity']));
									?>
									<div class="item_price_calculation">
										<?php echo $od['quantity']; ?> × <?php echo $this->Number->currency($od['subtotal'] / $od['quantity'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
									</div>
									<?php echo $this->Html->link(
										$this->Html->image('checkout/plus-sign.png', array('alt' => __('add one'))),
										array("controller" => "orders", "action" => "increment_item_quantity", $key),
										array('escape' => false, 'class' => 'increment-item', 'rel' => 'nofollow'));
									?>
									
								</div>
								<div class="checkout_price">							
									<?php echo $this->Number->currency($od['subtotal'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
								</div>
							</div>				
						</div>
					</div>

					<?php if ($i === $oodlenght): ?>	
						<div class="checkout_row_border_red">
							&nbsp;
						</div>
					<?php else: ?>
						<div class="checkout_row_border">
							&nbsp;
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>					
		</div>
	
	<!-- More items -->


	<!-- SUBTOTAL -->
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" ><p class="strong" style="font-size: 1.15em;"><?php echo __('Subtotal'); ?></p></div>
							<div class="checkout_price">							
								<?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
						</div>

						<!-- COLLAPSABLE BODY -->
						<?php if ($this->Session->read('Order.Order.coupon_offered_by') === 'restaurant'): ?>
							<div class="item_detail accordion-body collapse" id="coupon_description">

							</div>
						<?php elseif ('isFirstOrder'): ?>
							<div class="item_detail accordion-body collapse" id="coupon_description">
								<?php echo __('First order coupon'); ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- END COLLAPSABLE -->
	</div>

	<!-- COUPON -->
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">
					<?php if($this->Session->read('Order.Order.method_of_payment') === 'creditcard'): ?>
						<p class="strong accordion-heading"><?php echo __('Coupon'); ?></p>
					

					<div class="input-append" style="margin-bottom: 0">
						<?php
						echo $this->Form->input('Order.coupon_code', array(
							'id' => 'couponCode',
							'label' => FALSE,
							'append' => 'append',
							'div' => FALSE,
							'no_div' => TRUE,
							'style' => 'width: 245px;',
							'value' => $this->Session->check('Order.Order.coupon_code') ? $this->Session->read('Order.Order.coupon_code') : "",
							'title' => __('Enter coupon code here and update your order')));
						echo $this->Html->link(
							__('Apply'), 
							array("controller" => "orders", "action" => "apply_coupon"),
							array(
								'class' => 'btn btn-success addOption',
								'rel' => 'nofollow',
								'escape' => false, 
								'id' => 'apply_coupon',
								'style' => 'width: 60px; text-decoration: none;',
								'append' => 'append'));						
						?>
					</div>
                                                                        
                        <?php if($this->Session->read('Order.Order.coupon_discount') > 0): ?>                        
                    
                    <!-- Show Discount amount -->
                    <div class="bottom" style="font-size: 1.3em; padding-top: 10px;">
                        <div class="left " style="float: left;">
                            <?php echo __('Discount'); ?>
                        </div>
                        <div class="right strong red" style="margin-bottom: 0;">
                            <?php echo $this->Number->currency($this->Session->read('Order.Order.coupon_discount'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                        </div>
                    </div>
                        <?php endif; ?>
                    
                    <?php else: ?>
                    <p class="weak">
                        <?php echo __('Coupons available with credit card orders only'); ?>
                    </p>

                    <?php endif; ?>

				</div>
			</div>
		</div>
	</div>

	<!-- DELIVERY FEE -->
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" ><p class="strong" style="font-size: 1em;"><?php echo __('Delivery Fee'); ?></p></div>
							<div class="checkout_price">							
								<?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
						</div>

						<!-- COLLAPSABLE BODY -->
						<div class="item_detail accordion-body collapse" id="collapsable_subtotal">


						</div>

					</div>
				</div>
			</div>
			<div class="checkout_row_border">
				&nbsp;
			</div>
		</div>
		<!-- END COLLAPSABLE -->
	</div>


	<!-- GST -->
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" ><p class="strong" style="font-size: 1em;"><?php echo __('GST'); ?></p></div>
							<div class="checkout_price">							
								<?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
						</div>

						<!-- COLLAPSABLE BODY -->
						<div class="item_detail accordion-body collapse" id="collapsable_subtotal">


						</div>

					</div>
				</div>
			</div>
			<div class="checkout_row_border">
				&nbsp;
			</div>
		</div>
		<!-- END COLLAPSABLE -->
	</div>


	<!-- PST -->
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" ><p class="strong" style="font-size: 1em;"><?php echo __('PST'); ?></p></div>
							<div class="checkout_price">							
								<?php echo $this->Number->currency($this->Session->read('Order.Order.pst'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
						</div>

						<!-- COLLAPSABLE BODY -->
						<div class="item_detail accordion-body collapse" id="collapsable_subtotal">


						</div>

					</div>
				</div>
			</div>
			<div class="checkout_row_border">
				&nbsp;
			</div>
		</div>
		<!-- END COLLAPSABLE -->
	</div>


	<!-- TIP -->
    <?php // Remove Tips for one restaraurant ?>
                            <?php if ($location['Location']['id'] !== '528103ac-ddb8-43d3-a714-6a881ec880c8'): ?>
	<div class="accordion" id="items_details">
		<div class="checkout_order_row item">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" ><p class="strong" style="font-size: 1em;"><?php echo __('TIP'); ?></p></div>

						</div>

						<!-- COLLAPSABLE BODY -->
						<div class="item_detail accordion-body collapse" id="collapsable_subtotal">


						</div>

					</div>

					<div class="bottom">
												
						<div class="left">										
							<?php
							echo $this->Html->link(
								$this->Html->image('checkout/minus-sign.png', array('alt' => __('add one'))), 
								array("controller" => "orders", "action" => "decrement_tip", $key), 
								array('escape' => false, 'class' => 'decrement-item', 'rel' => 'nofollow' ));
							?>
							<div class="item_price_calculation">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
							<?php
							echo $this->Html->link(
								$this->Html->image('checkout/plus-sign.png', array('alt' => __('add one'))), 
								array("controller" => "orders", "action" => "increment_tip", $key), 
								array('escape' => false, 'class' => 'increment-item', 'rel' => 'nofollow'));
							?>

						</div>
						
						<div class="checkout_price">							
							<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
						</div>
					</div>	
				</div>
			</div>
			<div class="checkout_row_border_red">
				&nbsp;
			</div>
		</div>
	</div>

<?php endif; ?>

	<!-- TOTAL -->
	<div class="accordion">
		<div class="checkout_order_row item"  id="checkout_right_total">	
			<div class="checkout_order_row_inner">
				<div class="checkout_detail">

					<!-- COLLAPSABLE START -->
					<div class="accordion-group">
						<!-- COLLAPSABLE HEADING -->								
						<div class="accordion-heading">	
							<div class="left" >
								<p class="strong" style="font-size: 1.15em;" id="rightSideTotalLabel"><?php echo __('Total'); ?></p>
							</div>
							<div class="checkout_price" id="rightSideTotal">							
								<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</div>
						</div>

						<!-- COLLAPSABLE BODY -->
						<div class="item_detail accordion-body collapse" id="collapsable_subtotal">


						</div>

					</div>
				</div>
			</div>				
		</div>
		<!-- END COLLAPSABLE -->
	</div>
	
	<!-- Number of items in the Order -->
	<?php 
	// this is not mvc complient... Sorry
	$orderItemsCount = $this->Session->read('Order.OrderDetail');
	$orderItemsCount = count($orderItemsCount);
	?>
	<input type="hidden" value="<?php echo $orderItemsCount; ?>" id="orderItemsCount" data-message="<?php echo __("Removing one more of this item will empty your order.\nContinue?"); ?>"/>

	<?php endif; ?>
	<!-- Must be inline -->
	<script type="text/javascript">

	/**
	* Increment and Decrement links on form
	 */
	$('.increment-item').click(function(event){
        
        showPleaseWait();
        $('#placeOrderLink').removeAttr('disabled');

		// Update the order in the right panel
		$.ajax({
			url: $(this).prop('href'),
			error: function(){
                stopPleaseWait();
                alert('Error / Erreur');}
		}).done(function(msg){
            stopPleaseWait();            
			$('#checkout_right_wrapper').html(msg);			
			
			// update text on left side
			updateTextOnLeftSide();
		});			
		event.preventDefault();
	});
	
	$('.decrement-item').click(function(event){
		var answer = true;
        
        showPleaseWait();

		// Check if if decrement this item will delete the order because no items will be left in it
		if( $(this).attr('data-qty') === '1' && $('#orderItemsCount').val() === '1'){
            stopPleaseWait();
			 answer = confirm($('#orderItemsCount').attr('data-message'));
		}

		// Update the order in the right panel
		if(answer){			
			$.ajax({
				url: $(this).prop('href'),
				error: function(){
                    stopPleaseWait();
                    alert('Error / Erreur');}
			}).done(function(msg){
                stopPleaseWait();
                // update text on left side
				updateTextOnLeftSide();
				$('#checkout_right_wrapper').html(msg);								
			});			
		}
			
		event.preventDefault();
	});
	
	
	/**
	 * Apply the discount coupon
	 */
	$('#apply_coupon').click(function(event){
		
//		alert($('#couponCode').val());
//		if($('#couponCode').val()){
			var url = $(this).prop('href') + '/' + encodeURIComponent($('#couponCode').val());;

			// Update the order in the right panel
			$.ajax({
				url: url,	
				error: function(){alert('Error / Erreur');}
			}).done(function(msg){
				$('#checkout_right_wrapper').html(msg);
				updateTextOnLeftSide();
			});			
//		}
				
		// update text on left side
		var totalString = $('#rightSideTotalLabel').html() + ': ' + $('#rightSideTotal').html();
		$('#proceed_to_payment_label').html(totalString);
		event.preventDefault();
	});	
	
	/**
	 * When the order is change of the right side this updates the left side
	 * @returns {undefined}
	 */
	function updateTextOnLeftSide(){
		var totalString = $('#rightSideTotalLabel').html() + ': ' + $('#rightSideTotal').html();
		$('.proceed_to_payment_label').html(totalString);
	}
	</script>