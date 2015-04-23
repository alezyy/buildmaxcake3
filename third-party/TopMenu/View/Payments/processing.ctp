<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Processing your order...'); ?></h1>
		</div>
	</div>

	<div class="location_view" style="float: left;">

		<div style="width: 70%; float: left">
			<p>
				<?php echo __("Hello", $this->Session->read('Order.Order.first_name')); ?>
			</p>
			<p>
				<?php echo __('We are communicating with the restaurant! Please do <b>NOT</b> click your browser\'s back button!'); ?>
				<br/>
				<?php echo __('This should take less than 3 minutes <span class="small">but could take up to 5 minutes</span>'); ?>
			</p>
			<p class="alert alert-info">
				<?php echo __('Please do <b>not</b> close or navigate away (don\'t click the back or refresh button or go to another webpage) from this page (tab). '); ?>
			</p>
		</div>
		<div id="please_wait_big" style="float: right">
			<?php echo $this->Html->image('ajax-loader.gif', array('alt' => __('Processing...'))); ?>
			<?php
			// echo $this->Html->image('http://content.presentermedia.com/files/animsp/00006000/6703/chef_stiring_pot_anim_sm_wm.gif', array('alt' => __('Processing...'))); 
			?>
		</div>	

	</div>
	
	<?php if(!$is_tablet): ?>	
	<div class="gray_head_box" style="float: left;">
		<div class="gray_head_heading">
			<h1><?php echo __('In the meantime'); ?></h1>
		</div>
	</div>

	<div class="location_view" style="float: left;">
		<p class="strong">
			<?php echo __('Please tell us how you feel:'); ?>
		</p>
		<ul>
			<li><?php echo __('Follow us on'); ?> <a href="<?php echo Configure::read('Topmenu.twitter_url'); ?>" target="_blank"><?php echo __('Twitter'); ?></a></li>
			<li><?php echo __('Follow us on'); ?> <a href="<?php echo Configure::read('Topmenu.facebook_url'); ?>" target="_blank"><?php echo __('Facebook'); ?></a></li>
			<li>
				<?php echo $this->Html->link(__('Give us feedback by email'), 
					array(
						'controller' => 'contacts',
						'action' =>	'index'), 
					array(
						'target' => '_blank')); ?> 
			</li>
				
		</ul>
	</div>
	<?php endif; ?>
	
	
	<!-- ORDER RECAP -->
	<div class="gray_head_box" style="float: left;">
		<div class="gray_head_heading">
			<h1><?php echo __('Order recap'); ?></h1>
		</div>
	</div>
	<div class="location_view" style="float: left;">
		<div id="checkout-table" >
			<table class="table table-condensed table checkout" style="display: inline" >
				<thead>		
					<tr>
						<th id="title_item"><?php echo __('Item'); ?></th>
						<th id="title_description" style="width: 100%">
							<?php echo __('Description and Special Instructions'); ?>
						</th>
						<th id="title_price"><?php echo __('Unit price'); ?></th>
						<th id="title_quantity"><?php echo __('Quantity'); ?></th>
						<th id="title_total"><?php echo __('Total'); ?></th>
					</tr>
				</thead>
				<tbody

					<!-- menu items -->
					<?php
					$i = 0;
					foreach ($this->Session->read('Order.OrderDetail') as $od) {
						?>	

						<tr>
							<td>
								<span class="strong"><?php echo $od['name'] ?></span>
								<?php if (!empty($od['options'])) { ?>
									<!-- menu item options -->
									<table class="embedTable">
										<?php foreach ($od['options'] as $o) { ?>							
											<tr>
												<td>
													<?php echo $o['name'] ?>
												</td>
												<td>
													X <?php echo $o['quantity'] ?>
												</td>
												<td class="nowrap">
													<?php echo $this->Number->currency($o['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
												</td>
											</tr>
										<?php } ?>
									</table>
								<?php } ?>
							</td>
							<td>
								<span class="strong"><?php echo __('Description:'); ?></span><br/>
								<?php echo $od['description'] ?>
								<?php if (!empty($od['special_instruction'])) { ?>
									<hr/>
									<span class="strong"><?php echo __('Instruction:'); ?></span><br/>
									<?php echo $od['special_instruction'] ?> 
								<?php } ?>
							</td>
							<td class="number nowrap">
								<?php echo $this->Number->currency($od['subtotal']/$od['quantity'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</td>
							<td class="number">
								<?php echo $od['quantity']; ?>				
							</td>
							<td class="number nowrap">								
								<?php echo $this->Number->currency($od['subtotal'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</td>					
						</tr>
						<?php $i++;
					}
					?>

					<tr>
						<td colspan="2">
						
						</td>
						<th colspan="2" class="total"><?php echo __('Tip'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>							
						</th>
					</tr>
				</tbody>
				<tfoot>
					<tr id="deliveryChargeTotal">
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('Delivery charges'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
						</th>
					</tr>
					<tr>
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('Subtotal'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
						</th>
					</tr>
					<tr>
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('GST'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
						</th>
					</tr>
					<tr>
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('PST'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.pst'), $langSuffix . '_CA'); ?>
						</th>
					</tr>					
					<?php if($this->Session->check('Order.Order.coupon_discount')):?>
					<?php $oocd = $this->Session->read('Order.Order.coupon_discount'); ?>					
					<?php if($oocd > 0): ?>
					<tr>
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('Discount'); ?></th>
						<th class="number red">
							<?php echo $this->Number->currency($oocd, $langSuffix . '_CA'); ?>
						</th>
					</tr>
					<?php endif; ?>
					<?php endif; ?>
					<tr>
						<td colspan="2"></td>
						<th colspan="2" class="total"><?php echo __('Order Total'); ?></th>
						<th class="number">
							<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix . '_CA'); ?>
						</th>
					</tr>
				</tfoot>
			</table>
			

			<br/>
			
		
			</div>				

			
		</div>	
	
	
	
	<div style="display: none; ">
		<?php
		echo $this->Html->link(
			'Action to call', array(
			'action' => 'check_db',
			'controller' => 'payments'), array(
			'id' => 'check_db'));
		?>

		<?php
		echo $this->Html->link(
			'success page', array(
			'action' => 'approved',
			'controller' => 'payments',
			$orderId), array(
			'id' => 'success_page'));
		?>

		<?php
		echo $this->Html->link(
			'rejection page', array(
			'action' => 'rejected',
			'controller' => 'payments',
			'restaurant'), array(
			'id' => 'fail_page'));
		?>

	</div>

	<?php
	// pass some data to javascript
	echo $this->Form->hidden('pleaseDontLeave', array(
		'id' => 'pleaseDontLeave',
		'value' => __("WARNING!\n========\n\nThe transaction is in progress!\nYou cannot cancel the transaction by closing this page!\nPlease, wait until the transaction process finishes.\nIf you have any questions call us at 514-989-1233")
	));
		
	echo $this->Form->hidden('tiemout_delai', array(
		'id' => 'tiemout_delai',
		'value' => $timeout
	));
	echo $this->Form->hidden('maxAttemps', array(
		'id' => 'maxAttemps',
		'value' => Configure::read('Topmenu.max_attempts')
	));
	?>

	<?php echo $this->Html->script('processing'); ?>
<?php echo $this->Js->writeBuffer(); ?>
	
</div>