<?php
$this->Html->addCrumb(__('Orders'), array(
	'controller' => 'orders',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Order'));

$class = 'info';
switch (strtolower($order['Order']['overall_status'])) {

	case 'accepted':
	case 'completed':
	case 'complete':
		$class = 'success';
	break;

	case 'rejected':
	case 'canceled':
		$class = 'error';
	break;
}

?>
<div class="orders view span8">
<h2><?php echo __('Order'); ?></h2>
	<table width="100%">
		<tr valign="top">
			<td>
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($order['Order']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Date'); ?></dt>
					<dd>
						<?php echo $this->Date->formatDate($order['Order']['date']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Location'); ?></dt>
					<dd>
						<?php echo $this->Html->link($order['Location']['name'], array('controller' => 'locations', 'action' => 'view', $order['Location']['id'])); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('User'); ?></dt>
					<dd>
						<?php echo $this->Html->link($order['User']['email'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
						&nbsp;
					</dd>

					<dt><?php echo __('Paid By'); ?></dt>
					<dd>
						<?php echo h($order['Order']['paid_by']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Transaction Number'); ?></dt>
					<dd>
						<?php echo h($order['Order']['transaction_number']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Commission Percentage'); ?></dt>
					<dd>
						<?php echo h($order['Order']['commission_percentage']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Language'); ?></dt>
					<dd>
						<?php echo h($order['Order']['language']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Status'); ?></dt>
					<dd>
						<?php echo $this->Bootstrap->badge($order['Order']['overall_status'], $class); ?>
						&nbsp;
					</dd>					
					<dt><?php echo __('Method of payment'); ?></dt>
					<dd>
						<?php echo h($order['Order']['method_of_payment']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Gateway Status'); ?></dt>
					<dd>
						<?php echo h($order['Order']['gateway_status']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Overall Instruction'); ?></dt>
					<dd>
						<?php echo h($order['Order']['overall_status']); ?>
						&nbsp;
					</dd>


				</dl>
			</td>
			<td>
				<dl>
					<dt><?php echo __('First Name'); ?></dt>
					<dd>
						<?php echo h($order['Order']['first_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Last Name'); ?></dt>
					<dd>
						<?php echo h($order['Order']['last_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Address'); ?></dt>
					<dd>
						<?php echo h($order['Order']['address']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Address2'); ?></dt>
					<dd>
						<?php echo h($order['Order']['address2']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('City'); ?></dt>
					<dd>
						<?php echo h($order['Order']['city']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Province'); ?></dt>
					<dd>
						<?php echo h($order['Order']['state']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Postal Code'); ?></dt>
					<dd>
						<?php echo h($order['Order']['postal_code']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Door Code'); ?></dt>
					<dd>
						<?php echo h($order['Order']['door_code']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Cross Street'); ?></dt>
					<dd>
						<?php echo h($order['Order']['cross_street']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Phone'); ?></dt>
					<dd>
						<?php echo h($order['Order']['phone']); ?>
						&nbsp;
					</dd>

				</dl>
			</td>
			<td>
				<dl>
					<dt><?php echo __('Special Instruction'); ?></dt>
					<dd>
						<?php echo h($order['Order']['special_instruction']); ?>
						&nbsp;
					</dd>


					<dt><?php echo __('Requested for'); ?></dt>
					<dd>
						<?php echo $this->Date->formatDate($order['Order']['requested_for']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Expected Delivery Time'); ?></dt>
					<dd>
						<?php echo $this->Date->formatDate($order['Order']['expected_delivery_time']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Location Response'); ?></dt>
					<dd>
						<?php echo h($order['Order']['response']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Referrer'); ?></dt>
					<dd>
						<?php echo h($order['Order']['referrer']); ?>
						&nbsp;
					</dd>
				</dl>
			</td>
		</tr>
	</table>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> </li>
		<li>
			<?php
			echo $this->Form->postLink(
				__('Send to Device'),
				array(
					'action' => 'send',
					$order['Order']['id']
				),
				null,
				__('Are you sure you want to send order # %s to the printer?', $order['Order']['id'])
			);
			?>
		</li>
	</ul>
</div>

<div class="well" >
		<table class="table" >
			<thead>
				<tr>
					<th id="title_item"><?php echo __('Items'); ?></th>
					<th id="title_description"><?php echo __('Description'); ?></th>
					<th style="text-align:right;" id="title_price"><?php echo __('Unit Price'); ?></th>
					<th style="text-align:right;" id="title_quantity"><?php echo __('Quantity'); ?></th>
					<th style="text-align:right;" id="title_total"><?php echo __('Total'); ?></th>
				</tr>
			</thead>
			<tbody>

				<!-- menu items -->
				<?php
				$i = 0;
				foreach ($order['OrderDetail'] as $od) {
					?>

					<tr>
						<td>
							<span class="strong"><?php echo $od['name'] ?></span>
							<?php if (!empty($od['options'])) { ?>
								<!-- menu item options -->
								<?php if(!empty($od['options']) && is_array($od['options'])): ?>
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
								<?php endif; ?>
							<?php } ?>
						</td>
						<td>
							<?php echo $od['name'] ?>
							<?php if (!empty($od['special_instruction'])) { ?>
								<hr/>
								<span class="strong"><?php echo __('Instruction:'); ?></span><br/>
								<?php echo $od['special_instruction'] ?>
							<?php } ?>
						</td>
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
							<?php echo $this->Number->currency($od['price'] * $od['quantity'], 'en_CA'); ?>
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
					<th colspan="2" style="text-align: right"><?php echo __('Delivery charges'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['delivery_charge'], 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<th colspan="2" style="text-align:right"><?php echo __('Subtotal'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['subtotal'], 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<th colspan="2" style="text-align:right"><?php echo __('GST'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['gst'], 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<th colspan="2" style="text-align:right"><?php echo __('PST'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['pst'], 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<th colspan="2" style="text-align:right"><?php echo __('Tip'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['tip'], 'en_CA'); ?>
						</th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<th colspan="2" style="text-align:right"><?php echo __('Order\'s Total'); ?></th>
					<td style="text-align: right;min-width: 100px;">
						<?php echo $this->Number->currency($order['Order']['total'], 'en_CA'); ?>
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
