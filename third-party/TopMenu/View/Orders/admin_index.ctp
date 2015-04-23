<?php
$this->Html->addCrumb(__('Orders'));
?>
<script>
    $('#content_home').css('width', '95%');
</script>
<style>
    .center_cell th{ text-align: center; background-color: #F9F9F9; border-right: 1px solid #DDDDDD  }
    .center_cell th.empty{ border: none; background: transparent; }
</style>
<div class="orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan='15'>

			<?php
			echo $this->Form->create(
				'Query',
				array(
					'class' => 'form-search form-inline'
				)
			);
			echo $this->Form->input(
				'status',
				array(
					'options' => array(
						'processing' => __('Processing'),
						'complete'   => __('Complete'),
						'canceled'   => __('Canceled'),
						'rejected'   => __('Rejected'),
						'reimbursement'   => __('Reimbursement')

					),
					'empty'  => __('Show All'),
					'label'  => __('Status'),
					'div'    => false,
					'no_div' => true,
					'class'  => 'span1'
				)
			);
			echo $this->Form->input(
				'search',
				array(
					'label'       => false,
					'placeholder' => __('Search'),
					'div'         => false,
					'no_div'      => true
				)
			);

			echo $this->Form->input(
				'fields',
				array(
					'options' => array(
						'order_number' => __('Order Nº'),
						'location'     => __('Location'),
						'user'         => __('User'),
						'subtotal'     => __('Subtotal'),
						'total'        => __('Total')

					),
					'empty'  => __('Search All'),
					'label'  => __('Fields'),
					'div'    => false,
					'no_div' => true,
					'class'  => 'span1'
				)
			);

			echo $this->Form->input(
				'from',
				array(
					'label'       => false,
					'placeholder' => __('From Date'),
					'class'       => 'span2',
					'div'         => false,
					'no_div'      => true,
					'style'		  => 'margin-left:10px;'
				)
			);
			echo $this->Form->input(
				'to',
				array(
					'label'       => 'to',
					'placeholder' => __('To Date'),
					'class'       => 'span2 add-on',
					'div'         => false,
					'no_div'      => true
				)
			);
			echo $this->Form->submit(
				__('Search'),
				array(
					'div'   => false,
					'class' => 'btn btn-success'
				)
			);
            echo $this->Form->submit(
				__('Export to CSV'),
				array(
                    'name'  => 'exportToCSV',
					'div'   => false,
					'class' => 'btn btn-success'
				)
			);
            echo $this->Form->submit(
				__('Export ALL to CSV'),
				array(
                    'name'  => 'exportAllToCSV',
					'div'   => false,
					'class' => 'btn btn-success'
				)
			);
            echo $this->Form->input(
                'X',
                array(
                    'div'   => false,
                    'no_div'      => true,
                    'label' => false,
                    'value' => 'X',
                    'type' => 'reset',
                    'class' => 'btn btn-danger'
                ));			                  
			echo $this->Form->end();

			?>
		</td>
	</tr>    
    <tr class="center_cell">       
        <th colspan="1" ></th>
        <th colspan="2" style="background-color: #ccffcc"><?php echo __('USER'); ?></th>
        <th colspan="5" ></th>
        <th colspan="3" style="background-color: #ccccff"><?php echo __("STATUS"); ?></th>        
        <th colspan="3" style="background-color: #ffccff"><?php echo __("DISCOUNT"); ?></th>        
        <th colspan="2"></th>
    </tr>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th style="background-color: #ccffcc"><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th style="background-color: #ccffcc"><?php echo $this->Paginator->sort('#orders'); ?></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created', __('Date')); ?></th>
			<th><?php echo $this->Paginator->sort('total'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('method_of_payment'); ?></th>			
			<th style="background-color: #ccccff"><?php echo $this->Paginator->sort('gateway_status'); ?></th>
            <th style="background-color: #ccccff"><?php echo $this->Paginator->sort('device_status'); ?></th>
			<th style="background-color: #ccccff"><?php echo $this->Paginator->sort('overall_status'); ?></th>
			<th style="background-color: #ffccff"><?php echo $this->Paginator->sort('Has one'); ?></th>
			<th style="background-color: #ffccff"><?php echo $this->Paginator->sort('coupon_discount'); ?></th>			
			<th style="background-color: #ffccff"><?php echo $this->Paginator->sort('coupon_code'); ?></th>			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php 
	foreach ($orders as $order):
	?>

	<?php
	$class = 'info';
	switch ($this->ES->getValue($order, 'Order.overall_status')) {

		case 'accepted':
		case 'completed':
		case 'complete':
			$class = 'success';
		break;

		case 'rejected':
		case 'canceled':
			$class = 'error';
            break;
            
        case (strtotime($order['Order']['created'])  <  time() - ( 6 * MINUTE)):
            $class = 'warning';
        break;
    
        default:
            $class = 'info';
		break;
	}
	?>
    
	<tr class="<?php echo $class; ?>">
		<td>
			<?php echo h($order['Order']['id']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($this->ES->getValue($order, 'User.email'), array('controller' => 'users', 'action' => 'view', $this->ES->getValue($order, 'Order.user_id'))); ?>
		</td>
        <td><?php echo h($this->ES->getValue($order, 'Order.nb_orders')); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($this->ES->getValue($order, 'Location.name'), array('controller' => 'locations', 'action' => 'view', $this->ES->getValue($order, 'Location.id'))); ?>
		</td>
		<td><?php echo $this->Date->formatDate($order['Order']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Currency->currency($this->ES->getValue($order, 'Order.total')); ?>&nbsp;</td>
		<td><?php echo h($this->ES->getValue($order, 'Order.type')); ?>&nbsp;</td>
		<td><?php echo h($this->ES->getValue($order, 'Order.method_of_payment')); ?>&nbsp;</td>
        <td><?php echo h($this->ES->getValue($order, 'Order.gateway_status')); ?>&nbsp;</td>
        <td><?php echo h($this->ES->getValue($order, 'Order.device_status')); ?>&nbsp;</td>
        <td><?php echo h($this->ES->getValue($order, 'Order.overall_status')); ?>&nbsp;</td>
        <td><?php echo ($this->ES->getValue($order, 'Order.DISCOUNT_discount') > 0 ) ? __('YES') : ' - '; ?>&nbsp;</td>
        <td><?php echo $this->Currency->currency($this->ES->getValue($order, 'Order.coupon_discount')); ?>&nbsp;</td>        
        <td><?php echo h($this->ES->getValue($order, 'Order.coupon_code')); ?>&nbsp;</td>        
		<td class="actions">
			<?php echo $this->Html->link(__('Details'), array('action' => 'view', $this->ES->getValue($order, 'Order.id'))); ?>
			<?php echo $this->Html->link(__('OK'), 'javascript:void(0)', array('class' => 'okActionButton')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="pagination">
		<ul>
			<?php
			echo $this->Paginator->first('|<' . __('first'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			echo $this->Paginator->last(__('last') . ' >|', array(), null, array('class' => 'prev disabled'));
?>
		</ul>
	</div>

<?php
echo $this->Html->css('datepicker');
echo $this->Html->script('bootstrap-datepicker');
echo $this->Html->script('order_admin_index');
