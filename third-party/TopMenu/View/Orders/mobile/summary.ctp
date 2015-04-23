<h1><?php echo __('Your order details') ?></h1>

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
									<th><?php echo __('QTY'); ?></th>
									<th><?php echo __('Items'); ?></th>									
									<th><?php echo __('Price'); ?></th>
									<th></th>
								</tr>
								<tr>
									<td colspan="4" class="cart_dotted_line">&nbsp;</td>
								</tr>

								<?php if(!$this->Session->check('Order.OrderDetail')){?>
								<tr>
									<td colspan="4">
										<p class="category-description" style="text-align: center">
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
											<td>
												<?php echo $this->Number->currency($detail['subtotal'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
											</td>
											<td>
												<?php
												echo $this->Html->link( 
													'✖',
													array(
														'controller' => 'menuItems',
														'action' => 'remove_item',
														$k), 
													array(
														'class' => 'summary-ajax',
														'role' => 'button',
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
									<td colspan="2"><?php echo __('Delivery'); ?></td>
									<td>
										<?php
										echo $this->Number->currency(
											$this->Session->read('Order.Order.delivery_charge'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
										?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2"><?php echo __('Subtotal'); ?></td>
									<td>
										<?php
										echo $this->Number->currency(
											$this->Session->read('Order.Order.subtotal'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
										?>
									</td>
									<td></td>
								</tr>						
								<tr>
									<td colspan="2" ><?php echo __('Tip'); ?></td>
									<td id="tip_td">
										<?php
										echo $this->Number->currency(
											$this->Session->read('Order.Order.tip'), $langSuffix.  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
										?>
									</td>
									<td>
										<?php 
										echo $this->Html->link( '✖', '/tip_options/remove_tip', array(
											'class' => 'summary-ajax x_delete',
											'role' => 'button',
											'rel' => 'nofollow'));
										?>
									</td>
								</tr>
																<tr>
									<td colspan="2" class="strong">
										<?php echo __('Total'); ?>
									</td>
									<td id="total_td" class="strong">
										<?php
										echo $this->Number->currency(
											$this->Session->read('Order.Order.total'), $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
										?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="4" class="cart_dotted_line">&nbsp;</td>
								</tr>

<!--								<tr>
									<td colspan="3" style="text-align: right">
										<?php
										echo $this->Html->link(
											__('Delivery/Pick Up time'), 
											array(
												'controller' => 'orders',
												'action' => 'future_time_form'),
											array(
												'class' => 'item-ajax',
												'rel' => 'nofollow'));
										?>
									</td>
									<td></td>
								</tr>-->
						
						</table>
						<br/>
						<div class="btn-group btn-group-vertical pull-right" style="width: 100%">
							
							<?php
							echo $this->Html->link(
									__('Clear order'), '/menu_items/empty_cart/'.$locationId, 
									array(
										'role' => 'button',
										'class' => 'btn',
										'rel' => 'nofollow'),
									__('Are you sure you want to delete the order?'));
							?>

							<?php 
							$delType = $this->Session->read('Order.Order.type');
							echo $this->Order->orderTypeSwitcher($delType,$locationUrl, $locationId)
							?>
							
							<?php
								echo $this->Html->link(
										__('Back to menu'), 
										array(
											'controller' => 'locations',
											'action' => 'view',
											'location' => $locationUrl,
											'sector' => $locationSlug),
										array(
											'role' => 'button',
											'class' => 'btn',
											'div' => false));
							?>

								<?php if($this->Session->check('Order')): ?>
								
										<?php
										echo $this->Form->submit(
											__('Proceed to checkout'), 
											array(
												'class' => 'btn btn-success',
												'style' => 'width: 100%;',
												'div' => false,
												$this->Session->read('enableCheckout')?'FALSE':'disabled'));?>
								
								<?php endif; ?>														
								

						<?php
						echo $this->Form->hidden('user_id', array(
							'value' => $this->Session->read('Auth.User.id')));				
						echo $this->Form->hidden('location_id', array(
							'value' => $locationId));				
						echo $this->Form->end(); 
						?>
						<div id="option"></div>
