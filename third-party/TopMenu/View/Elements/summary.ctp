
<div class="search_wrapper">
	&nbsp;
	<div class="other_pages_left">
		<div id="search" data-spy="affix" data-offset-top="260" data-offset-bottom="250" style="margin-left: 44px">
			<div class="small_header_cntnr">
				<h1 class="small_header_title"><strong><?php echo __('Your Order'); ?></strong></h1>
			</div>

			<div class="other_pages_right_tab">
																				<?php
				echo $this->Form->create('Order', array(
					'url' => array('controller' => 'orders', 'action' => 'checkout')));
				?>
				<table class="cart_table_content" id="order_content">
					<tbody>

						<?php if (!empty($setFlashLevel)) { ?>
							<tr>
								<td colspan="4">
									<div id="flashMessage" class="alert alert-<?php echo $setFlashLevel; ?> fade in" data-alert="alert"></a>
										<?php echo $setFlashMessage; ?>
									</div>
								</td>
							</tr>
						<?php } ?>


						<tr>
							<th class="arial10 left" ><?php echo __('QTY'); ?></th>
							<th class="arial10 left"><?php echo __('Items'); ?></th>									
							<th class="arial10 right"><?php echo __('Price'); ?></th>
							<th></th>
						</tr>
						<tr>
							<td colspan="4" class="cart_dotted_line">&nbsp;</td>
						</tr>

						<?php if(!$this->Session->check('Order.OrderDetail')){?>
						<tr>
							<td colspan="4">
								<p class="category-description center">
									<br/>
									<?php echo __('Select items from the menu to start ordering'); ?>
								</p>
							</td>
						</tr>
						<? }else{?>
							<?php foreach ($this->Session->read('Order.OrderDetail') as $k => $detail) { ?>
								<tr>
									<td>
										<?php echo $detail['quantity']; ?>
									</td>
									<td>
										<?php echo $detail['name']; ?>
									</td>									
									<td class="right nowrap">
										<?php echo $this->Number->currency($detail['subtotal'], $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
									</td>
									<td class="right">
										<?php
										echo $this->Html->link( 
											'×',
											array(
												'controller' => 'menuItems',
												'action' => 'remove_item',
												$k), 
											array(
												'class' => 'summary-ajax',
												'rel' => 'nofollow'));
										?>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
						<tr>
							<td colspan="4" class="cart_dotted_line">&nbsp;</td>
						</tr>
						<tr>
							<td></td>
							<td class="right"><?php echo __('Subtotal'); ?></td>
							<td class="right nowrap">
								<?php
								echo $this->Number->currency(
									$this->Session->read('Order.Order.subtotal'), $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
								?>
							</td>
							<td></td>
						</tr>						
						<tr>
							<td></td>
							<td class="right strong">
								<?php echo __('Total'); ?>
							</td>
							<td id="total_td" class="strong right nowrap">
								<?php
								echo $this->Number->currency(
									$this->Session->read('Order.Order.total'), $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
								?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td class="right"><?php echo __('Tip'); ?></td>
							<td id="tip_td" class="right nowrap">
								<?php
								echo $this->Number->currency(
									$this->Session->read('Order.Order.tip'), $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
								?>
							</td>
							<td class="right">
								<?php 
								echo $this->Html->link( '×', '/tip_options/remove_tip', array(
									'class' => 'summary-ajax',
									'rel' => 'nofollow'));
								?>
							</td>
						</tr>
						<tr>
							<td colspan="4" class="cart_dotted_line">&nbsp;</td>
						</tr>

												<tr>
							<td colspan="3" class="right">
								<?php
								echo $this->Html->link(__('Clear order'), '/menu_items/empty_cart', array('class' => 'summary-ajax'));
								?>
							</td>
							<td></td>
						</tr>
												<tr>
							<td colspan="3" class="right">
								<?php
								echo $this->Html->link(__('Delivery/Pick Up time'), '/orders/set_future_time', array('class' => 'summary-ajax'));
								?>
							</td>
							<td></td>
						</tr>

						<tr>
							<td colspan="3" class="right">
								<?php
								echo $this->Form->radio(
										'type', 
										array('delivery' => __('Delivery'), 'pickup' => __('Pick Up')), 
										array(
											'separator' => '<br/>', 
											'label' => FALSE,
											'legend' => FALSE,
											'value' => 'delivery'));
								?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="4" id="checkout_button">
								<?php
								echo $this->Form->submit(
									__('Proceed to checkout'), 
									array('class' => 'btn btn-success'));
								?>
							</td>
							<td></td>
						</tr>
					</tbody>
			
				</table>	
				<?php
				echo $this->Form->hidden('user_id', array(
					'value' => $this->Session->read('Auth.User.id')));				
				echo $this->Form->hidden('location_id', array(
					'value' => $locationId));				
				echo $this->Form->end(); 
				?>
				<div id="option"></div>
			</div>
			<div class="left_box-shadow">&nbsp;</div>
		</div>
	</div>
</div>
