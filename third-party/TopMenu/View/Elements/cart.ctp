<div class="page-header no-margin">
	<h3 class="text-center text-red"><strong><?php echo __('Your Order'); ?></strong></h3>
</div>

        
<?php if (!isset($isPdfLocation) || !$isPdfLocation): ?>
	<?php
	echo $this->Form->create('Order', array(
		'url' => array('controller' => 'orders', 'action' => 'checkout')));
	?>
	<table class="table no-margin" id="order_content">

		<tr>
			<th class=""><?php echo __('Items'); ?></th>															
			<th class="text-right"><?php echo __('Price'); ?></th>
			<th></th>
		</tr>
	</table>

		
	<table class="table">
	<?php if (!$this->Session->check('Order.OrderDetail')) : ?>
		
		<p class="alert alert-warning center">
			<?php echo __('Select items from the menu to start ordering'); ?>
		</p>

	<?php else : ?>
		<?php foreach ($this->Session->read('Order.OrderDetail') as $k => $detail) : ?>
			<tr>
				<td>
				<?php echo "<b>". $detail['quantity']."x</b> ".$detail['name']; ?>
				</td>							
				<td class="text-right no-wrap">
				<?php echo $this->Number->currency($detail['subtotal'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
				</td>
				<td class="">
				<?php
				echo $this->Html->link(
					'<i class="fa fa-minus-circle text-red"></i>', array(
					'controller' => 'menuItems',
					'action' => 'remove_item',
					$k), array(
					'class' => 'ajax_cart',
					'escape' => false,
					'role' => 'button',
					'rel' => 'nofollow'));
				?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
		<tr>
			<td class="right"><?php echo __('Delivery'); ?></td>
			<td class="text-right">
		<?php
		echo $this->Number->currency(
			$this->Session->read('Order.Order.delivery_charge'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
		?>
			</td>
			<td></td>
		</tr>						
		<tr>					
			<td class="right"><?php echo __('Subtotal'); ?></td>
			<td class="text-right">
				<?php
				echo $this->Number->currency(
					$this->Session->read('Order.Order.subtotal'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
				?>
			</td>
			<td></td>
		</tr>		
		<tr>
			<td class="right"><?php echo __('Tip'); ?></td>
			<td id="tip_td" class="text-right">
				<?php
				echo $this->Number->currency(
					$this->Session->read('Order.Order.tip'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
				?>
			</td>
			<td class="">
				<?php
				echo $this->Html->link('<i class="fa fa-minus-circle text-red"></i>', '/tip_options/remove_tip', array(
				'class' => 'ajax_cart',
				'escape' => false,
				'role' => 'button',
				'rel' => 'nofollow'));
				?>
			</td>
		</tr>
		<tr>
			<td class="right strong">
				<h3><?php echo __('Total'); ?></h3>
			</td>
			<td class="text-right no-wrap">
				<h3><strong id="cartTotal"> <?php
				echo $this->Number->currency(
					$this->Session->read('Order.Order.total'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
				?>
				</strong></h3>
			</td>
			<td></td>
		</tr>
				
	</table>

	<?php echo $this->Session->flash('sidebar'); ?>	
		
	<?php if ($this->Session->check('Order')): ?>
		<div class="text-center">
			<?php
			echo $this->Html->link(
				__('Clear order'), "/menu_items/empty_cart/{$location['Location']['id']}", array(
				'class' => 'text-center ajax_cart'), __('Are you sure you want to delete the order?')); ?> <br/>

			<?php
			$delType = $this->Session->read('Order.Order.type');
			
			
			echo $this->Form->submit(
				__('Checkout'), array(
				'class' => 'btn btn-success btn-block',
				'div' => false));
			

	endif; ?>
			<?php
			echo $this->Form->hidden('user_id', array(
				'value' => $this->Session->read('Auth.User.id')));
			echo $this->Form->hidden('location_id', array(
				'value' => $location['Location']['id']));
			echo $this->Form->end();
			?>
			<div class="space"></div>
		</div>
<?php else: ?>
    <p class="strong" style="padding: 5px"><?php echo __('This restaurant does not offer online ordering'); ?></p>
<?php endif; ?>
	