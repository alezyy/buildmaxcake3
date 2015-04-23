<script>
	// Horrible hack cause i'm lazy
	$('#content_home').css('width', '95%');
</script>
<?php
$this->Html->addCrumb(__('Orders'), array(
	'controller' => 'orders',
	'action'	 => 'index'
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
<br/>
<br/>
<div class="orders view ">
    <h2><?php echo __('Order'); ?></h2>

    <div>
        <span class="strong"><?php echo __('Actions'); ?>:</span>
		<?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> | 
		<?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> | 
		<?php
		echo $this->Form->postLink(
			__('Send to Device'), array(
			'action' => 'send',
			$order['Order']['id']
			), null, __('Are you sure you want to send order # %s to the printer?', $order['Order']['id'])
		);
		?> |
		<?php
		echo $this->Form->postLink(
			__('Refund Order'), array(
			'action' => 'admin_refund',
			$order['Order']['id']
			), null, __('Are you sure you want to REFUND order # %s ?', $order['Order']['id'])
		);
		?>
    </div>
	
	<div style="height: 2%; width: 100%; float: left;">&nbsp;</div>

    <div style="float: left; width: 69%; text-align: center">
        <div style="float: left; width: 39%; text-align: center">
            <table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0"">
                <thead><tr><th colspan="2"><?php echo __('Order Information'); ?></tr></thead>
                <tbody>
                    <tr>
                        <th style="width:100px"><?php echo __('Id'); ?></td>
                        <td style="width:100px"><?php echo h($order['Order']['id']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Date'); ?></td>
                        <td><?php echo $this->Date->formatDate($order['Order']['created'], null, "%d-%m-%Y %k:%M"); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Payment'); ?></td>
                        <td><?php echo h($order['Order']['method_of_payment']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Pickup/Delivery'); ?>
                        <td><?php echo h($order['Order']['type']); ?></td>
                    </tr>            
                </tbody>
            </table>
        </div>
		<div style="float: left; width: 2%">&nbsp;</div>

        <div style="float: left; width: 59%; text-align: center">
            <table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0" >
                <thead><tr><th colspan="2"><?php echo __('Order Status'); ?></tr></thead>
                <tbody>
                    <tr>
                        <th><?php echo __('Transaction Number'); ?></td>
                        <td><?php echo ($order['Order']['transaction_number'] === 'cash') ? __("N/A") : h($order['Order']['transaction_number']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Gateway Status'); ?></td>
                        <td>						<?php echo h($order['Order']['gateway_status']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Location Response'); ?></td>
                        <td><?php echo h($order['Order']['response']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Final Status'); ?></td>
                        <td><?php echo $this->Bootstrap->badge($order['Order']['overall_status'], $class); ?></td>
                    </tr>			
                    <tr>
                        <th><?php echo __('Expected Delivery Time'); ?></td>
                        <td><?php echo $this->Date->formatDate($order['Order']['expected_delivery_time']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left; width: 100%; text-align: center">
            <table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
                <thead><tr><th colspan="2"><?php echo __("Restaurant Information"); ?></tr></thead>
                <tbody>
                    <tr>
                        <th><?php echo __('Location'); ?></th>
                        <td><?php echo $this->Html->link($order['Location']['name'], array('controller' => 'locations', 'action' => 'view', $order['Location']['id'])); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Special instructions:'); ?></td>
                        <td><?php echo h($order['Order']['special_instruction']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	<div style="width: 2%;float: left;">&nbsp;</div>

    <div style="float: left; width: 29%; text-align: center">
        <div style="float: left; width: 100%; text-align: center">
            <table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
                <thead><tr><th colspan="2"><?php echo __("Client's Information"); ?></tr></thead>
                <tbody>
                    <tr>
                        <th><?php echo __('First Name'); ?></td>
                        <td><?php echo h($order['Order']['first_name']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Last Name'); ?></td>
                        <td><?php echo h($order['Order']['last_name']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Email'); ?></td>
                        <td><?php echo h($order['Order']['email']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Phone'); ?></td>
                        <td><?php echo h($order['Order']['phone']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Address'); ?></td>
                        <td><?php echo h($order['Order']['address']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Address2'); ?></td>
                        <td><?php echo h($order['Order']['address2']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('City'); ?></td>
                        <td><?php echo h($order['Order']['city']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Postal Code'); ?></td>
                        <td><?php echo h($order['Order']['postal_code']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Door Code'); ?></td>
                        <td><?php echo h($order['Order']['door_code']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Cross Street'); ?></td>
                        <td><?php echo h($order['Order']['cross_street']); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo __('Language'); ?></td>
                        <td><?php echo h($order['Order']['language']); ?></td>
                    </tr>                         
                    <tr>
                        <th><?php echo __('Id'); ?></td>
                        <td><?php echo h($order['User']['id']); ?></td>
                    </tr>                         
                </tbody>
            </table>
        </div>
    </div>

</div>


<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0"" >
    <thead>
        <tr>
            <th id="title_item"><?php echo __('Items'); ?></th>
            <th id="title_description"><?php echo __('Description'); ?></th>
            <th style="text-align:right;" id="title_price" class="number"><?php echo __('Unit Price'); ?></th>
            <th style="text-align:right;" id="title_quantity" class="number"><?php echo __('Quantity'); ?></th>
            <th style="text-align:right;" id="title_total" class="number"><?php echo __('Total'); ?></th>
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
						<table class="embedTable">		
							<?php
							$odOptions = explode('||', $od['options']);
							array_pop($odOptions);
							?>
							<?php
							foreach ($odOptions as $odo) {
								$optionField = explode('~', $odo);
								?>
								<tr>
									<td>
										<?php echo $optionField[0] ?>
									</td>
									<td>
										X <?php echo $optionField[1] ?>
									</td>
									<td class="nowrap">
										<?php echo $this->Number->currency($optionField[2], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					<?php } ?>
				</td>
				<td>
					<?php if (!empty($od['special_instruction'])) { ?>
						<hr/>
						<span class="strong"><?php echo __('Instruction:'); ?></span><br/>
						<?php echo $od['special_instruction'] ?>
					<?php } ?>
				</td>
				<td class="number nowrap" style="text-align:right;">
					<?php echo $this->Number->currency($od['subtotal'] / $od['quantity'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
				</td>
				<td class="number" style="text-align:right;">
					<?php echo $od['quantity']; ?>								
				</td>
				<td class="number nowrap" style="text-align:right;">
					<?php echo $this->Number->currency($od['subtotal'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
				</td>					
			</tr>

			<?php
			$i++;
		}
		?>
		<tr>
			<th><?php echo __('Special instructions:'); ?></th>
			<td colspan="4">
				<?php echo $this->Session->read('Order.Order.special_instruction'); ?>
			</td>
		</tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="text-align: right"><?php echo __('Delivery charges'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['delivery_charge'], 'en_CA'); ?>
                </th>
        </tr>
        <tr>

            <th colspan="4" style="text-align:right"><?php echo __('Subtotal'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['subtotal'], 'en_CA'); ?>
                </th>
        </tr>
		<?php if ($order['Order']['coupon_offered_by'] === 'restaurant'): ?>
			<tr>
				<td></td>
				<th colspan="4" style="text-align:right"><?php echo __('Discount'); ?></th>
				<td style="text-align: right;min-width: 100px;">
					(<?php echo $this->Number->currency($order['Order']['coupon_discount'], 'en_CA'); ?>)
				</td>
			</tr>
		<?php endif; ?>
        <tr>

            <th colspan="4" style="text-align:right"><?php echo __('GST'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['gst'], 'en_CA'); ?>
                </th>
        </tr>
        <tr>

            <th colspan="4" style="text-align:right"><?php echo __('PST'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['pst'], 'en_CA'); ?>
                </th>
        </tr>
        <tr>

            <th colspan="4" style="text-align:right"><?php echo __('Tip'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['tip'], 'en_CA'); ?>
                </th>
        </tr>
		<?php if ($order['Order']['coupon_offered_by'] === 'topmenu'): ?>
			<tr>

				<th colspan="4" style="text-align:right"><?php echo __('Discount'); ?></th>
				<td style="text-align: right;min-width: 100px;">
					(<?php echo $this->Number->currency($order['Order']['coupon_discount'], 'en_CA'); ?>)
				</td>
			</tr>
		<?php endif; ?>
        <tr>

            <th colspan="4" style="text-align:right"><?php echo __('Order Total'); ?></th>
            <td style="text-align: right;min-width: 100px;">
				<?php echo $this->Number->currency($order['Order']['total'], 'en_CA'); ?>
                </th>
        </tr>       
    </tfoot>
</table>
