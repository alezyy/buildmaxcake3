<?php
$this->Html->addCrumb(__('Orders'), array(
	'controller' => 'orders',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Order'), array(
	'controller' => 'orders',
	'action' => 'view',
	$this->Form->value('Order.id')
));
$this->Html->addCrumb(__('Edit Order'));
?>
<div class="orders form span10">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Order'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('overall_status', array(
			'options' => array('accepted' => __('Accepted'), 'processing' => __('Processing'), 'canceled' => __('Canceled'))
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
