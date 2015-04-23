<div class="deliveryAddresses view span8">
<h2><?php echo __('Delivery Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($deliveryAddress['User']['email'], array('controller' => 'users', 'action' => 'view', $deliveryAddress['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Secondary Phone'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['secondary_phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Door Code'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['door_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cross Street'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['cross_street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Province'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($deliveryAddress['DeliveryAddress']['postal_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Delivery Address'), array('action' => 'edit', $deliveryAddress['DeliveryAddress']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Delivery Address'), array('action' => 'delete', $deliveryAddress['DeliveryAddress']['id']), null, __('Are you sure you want to delete # %s?', $deliveryAddress['DeliveryAddress']['id'])); ?> </li>
	</ul>
</div>
