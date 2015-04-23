<div style="
	 width: 90%;
	 margin: auto;">

	<p>Hello <?php echo $User['Profile']['first_name'] ?>,</p>

	<p>Thank you for placing an order on TOPMENU.COM.</p>

	<p>Here are your order details: </p>

	<hr/>

	<div style="width: 100%">

		<p class="strong"><?php echo __('Invoice: ') . $this->Session->read('Order.Order.id'); ?></p>
		<p><?php echo $Location['name']; ?><br/>					
			<?php echo $Location['building_number'] . " " . $Location['street']?><br/>
			(<?php echo $Location['province']; ?>) <?php echo $Location['postal_code']; ?>
		</p>
				
		<?php if ($this->Session->check('Order.Ordder.type')): ?>
		<p>
			<?php if ($this->Session->read('Order.Ordder.type') === 'delivery'): ?>
				<?php echo __('The order will be delivered to you') ?>
			<?php else: ?>
				<?php echo __('The order will be picked up by you') ?>
			<?php endif; ?>
		</p>
		<?php endif; ?>		
		
	</div>				

	<hr/>

	<div style="
		 width: 90%;
		 margin: auto;" >
		<table style="
			   display: inline;
			   width: 90%" >
			<thead>		
				<tr>
					<th id="title_item">Items</th>
					<th id="title_price">Prix unitaire</th>
					<th id="title_quantity">QTY</th>
					<th id="title_total">Total</th>
				</tr>
			</thead>
			<tbody>

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
											<td>
												<?php echo $this->Number->currency($o['price'], 'en_CA'); ?>
											</td>
										</tr>
									<?php } ?>
								</table>
							<?php } ?>
						</td>
	<!--						<td>
						<?php echo $od['description'] ?>
						<?php if (!empty($od['special_instruction'])) { ?>
									<hr/>
									<span class="strong"><?php echo __('Instruction:'); ?></span><br/>
							<?php echo $od['special_instruction'] ?>
						<?php } ?>
						</td>-->
						<td style="
							text-align: right;
							min-width: 100px;">
							<?php echo $this->Number->currency($od['price'], 'en_CA'); ?>
						</td>
						<td style="
							text-align: right;
							min-width: 50px;">
							<?php
							echo $od['quantity'];
							?>							
						</td>
						<td style="
							text-align: right;
							min-width: 100px;">
							<?php echo $this->Number->currency($od['subtotal'], 'en_CA'); ?>
						</td>					
					</tr>
					<?php
					$i++;
				}
				?>

			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<th colspan="2" style="text-align: right"><?php echo __('Delivery charges'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Subtotal'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), 'en_CA'); ?>
						</th>
				</tr>
				<?php if ($this->Session->read('Order.Order.coupon_offered_by') === 'restaurant'): ?>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Discount'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						(<?php echo $this->Number->currency(number_format($this->Session->read('Order.Order.coupon_discount'), 2, '.', ''), 'en_CA'); ?>)
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('GST'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('PST'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.pst'), 'en_CA'); ?>
						</th>
				</tr>					
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Tip'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), 'en_CA'); ?>
						</th>
				</tr>
				<?php if ($this->Session->read('Order.Order.coupon_offered_by') === 'topmenu'): ?>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Discount'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						(<?php echo $this->Number->currency(number_format($this->Session->read('Order.Order.coupon_discount'), 2, '.', ''), 'en_CA'); ?>)
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Order Total'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), 'en_CA'); ?>
					</td>
				</tr>

				<tr>
					<th><?php echo __('Special instructions:'); ?></th>
					<td colspan="4">
						<?php echo $this->Session->read('Order.Order.special_instruction'); ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>	

	<hr/>
	<p>
		The restaurant <?php echo $Location['name'] ?> is preparing your order.<!-- Your order will be delivered as soon as possible on : 
		<?php setlocale(LC_ALL, 'en_CA'); ?>
		<?php echo strftime('%B %e', strtotime($Order['Order']['requested_for'])); ?>-->
	</p>
	<p>If you have any questions regarding your delivery, please contact the restaurant: <?php echo $Location['name'] ?> at <?php echo $Location['phone'] ?> </p>
	<p><a href="http://messenger.providesupport.com/messenger/topmenuweb.html">Customer Service Top menu</a></p>
	<div style="
		font-weight: bold;
        background-color: red;
        height: 40px;
        line-height: 40px;
        text-align: center;
        color: black;">
		<a href='https://<?php echo $_SERVER['SERVER_NAME'] ?>/en/ratings/user_add/<?php echo $reviewId ?>/<?php echo $User['User']['id']; ?>/<?php echo $this->Session->read('Order.Order.id'); ?>'
           style="color: white;font-size: 20px;">
			Write a review for this order!
		</a>
	</div>



	<!-- force location_view div to go to bottom --> 
	<table style="width: 100%;">
		<tr><td>&nbsp;</td></tr>
	</table>
</div>
