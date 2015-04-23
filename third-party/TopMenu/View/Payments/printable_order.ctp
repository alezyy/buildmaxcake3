<?php echo $this->Html->css('docs') ?>
<div class="noPrint" style="color: red; font-size: 1.2em;">
	<p>
		<?php echo __('Sorry, an error occured will sending your invoice to your email. Print this as your order'); ?><br/>	
		<?php echo __('To print from a PC, type CTRL+P'); ?>
		<?php echo __('To print from a Mac, type Command+P'); ?>
		<?php echo __('From a mobile device do a screen shot'); ?>
	</p>
	<p>
		<?php echo $this->Html->link(__('Home'), '/'); ?>
	</p>
</div>

<div class="location_view">

			<div style="width: 100%">
				<div class="half-left">
					<span class="strong"><?php echo $location['Location']['name']; ?></span>
					<br/>
					<?php echo $location['Location']['short_address']; ?>
				</div>
				<div class="half-right">
					<?php if ($requested_for !== FALSE) { ?>
						<span class="strong"><?php echo __('Estimated time of reception:'); ?></span>
						<br/>
						<?php echo $requested_for; ?>
					<?php } ?>
				</div>	
			</div>
			<div class="long_dotted_line"></div>

			<div style="
				 width: 90%;
				 max-width: 700px;" >
				<table style="display: inline" >
					<thead>		
						<tr>
							<th id="title_item"><?php echo __('Item'); ?></th>
							<th id="title_description">
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
									<?php echo $this->Number->currency($od['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
								</td>
								<td class="number nowrap">
									<?php echo $od['quantity'] ?>							
								</td>
								<td class="number no_wrap">
									<?php echo $this->Number->currency($od['subtotal'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
								</td>					
							</tr>
							<?php
							$i++;
						}
						?>

					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('Delivery charges'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('Subtotal'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('GST'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('PST'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.qst'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</th>
						</tr>					
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('Tip'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
							</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<th colspan="2" class="total"><?php echo __('Order Total'); ?></th>
							<th class="number no_wrap">
								<?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
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
	

				<!-- force location_view div to go to bottom -->
				<table style="width: 100%;">
					<tr><td>&nbsp;</td></tr>
				</table>
			</div>	

		</div>