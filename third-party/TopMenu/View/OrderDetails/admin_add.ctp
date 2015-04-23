<div class="orderDetails form">
<?php echo $this->Form->create('OrderDetail'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Order Detail'); ?></legend>
	<?php
		echo $this->Form->input('order_id');
		echo $this->Form->input('menu_item_id');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('quantity');
		echo $this->Form->input('price');
		echo $this->Form->input('options');
		echo $this->Form->input('special_instruction');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Order Details'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menu Items'), array('controller' => 'menu_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu Item'), array('controller' => 'menu_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
