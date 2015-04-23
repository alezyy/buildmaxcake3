<div class="deviceOrders view span8">
<h2><?php echo __('Device Order'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deviceOrder['DeviceOrder']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo $this->Html->link($deviceOrder['Order']['id'], array('controller' => 'orders', 'action' => 'view', $deviceOrder['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($deviceOrder['Location']['name'], array('controller' => 'locations', 'action' => 'view', $deviceOrder['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order String'); ?></dt>
		<dd>
			<?php echo h($deviceOrder['DeviceOrder']['order_string']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recorded Time'); ?></dt>
		<dd>
			<?php echo h($deviceOrder['DeviceOrder']['recorded_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Device Order'), array('action' => 'edit', $deviceOrder['DeviceOrder']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Device Order'), array('action' => 'delete', $deviceOrder['DeviceOrder']['id']), null, __('Are you sure you want to delete # %s?', $deviceOrder['DeviceOrder']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Orders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Order'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
	</ul>
</div>
