<div style="
	 width: 90%;
	 margin: auto;">

	<p>Bonjour <?php echo $User['Profile']['first_name'] ?>,</p>

	<p>Merci d'avoir command&eacute; sur TOPMENU.COM.</p>

	<p>Trouvez ci-dessous les d&eacute;tails de votre commande :</p>

	<hr/>

	<div style="width: 100%">

		<p class="strong">Commande : <?php echo $this->Session->read('Order.Order.id'); ?></p>
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
					<th id="title_quantity">QT&Eacute;</th>
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
												<?php echo $this->Number->currency($o['price'], 'fr_CA'); ?>
											</td>
										</tr>
									<?php } ?>
								</table>
							<?php } ?>
						</td>
	<!--						<td>
							<span class="strong"><?php echo __('Description:'); ?></span><br/>
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
							<?php echo $this->Number->currency($od['price'], 'fr_CA'); ?>
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
							<?php echo $this->Number->currency($od['subtotal'], 'fr_CA'); ?>
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
						<?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), 'fr_CA'); ?>
						</th>
				</tr>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Subtotal'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), 'fr_CA'); ?>
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
						<?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), 'fr_CA'); ?>
						</th>
				</tr>
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('PST'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.pst'), 'fr_CA'); ?>
						</th>
				</tr>					
				<tr>
					<td></td>
					<th colspan="2" style="text-align:right"><?php echo __('Tip'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), 'fr_CA'); ?>
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
						<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), 'fr_CA'); ?>
						</th>
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
		Le restaurant <?php echo $Location['name'] ?> a pris votre commande en charge.<!-- Vous serez livr&eacute; dans les plus brefs d&eacute;lais le:
		<?php setlocale(LC_ALL, 'fr_CA'); ?>
		<?php echo strftime('%e %B', strtotime($Order['Order']['requested_for'])); ?>-->
	</p>																				
	<p>Si vous avez des questions concernant votre livraison, contactez le restaurant <?php echo $Location['name'] ?> au <?php echo $Location['phone'] ?> </p>
	<p><a href="http://messenger.providesupport.com/messenger/topmenuweb.html">Service &agrave; la client&egrave;le Top menu</a></p>
	<div style="
		font-weight: bold;
        background-color: red;
        height: 40px;
        line-height: 40px;
        text-align: center;
        color: black;">
		<a href='https://<?php echo $_SERVER['SERVER_NAME'] ?>/en/ratings/user_add/<?php echo $reviewId ?>/<?php echo $User['User']['id']; ?>/<?php echo $this->Session->read('Order.Order.id'); ?>'
           style="color: white;font-size: 20px;">
			Commentez ce repas!
		</a>
	</div>


	<!-- force location_view div to go to bottom -->
	<table style="width: 100%;">
		<tr><td>&nbsp;</td></tr>
	</table>
</div>
