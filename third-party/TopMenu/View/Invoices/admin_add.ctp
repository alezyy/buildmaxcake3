<?php
$this->Html->addCrumb(__('Invoices'), array(
	'controller' => 'invoices',
	'action' => 'index'
));
$this->Html->addCrumb(__('Add Invoice'));
?>
<div class="invoices form span10">
<?php echo $this->Form->create('Invoice'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Invoice'); ?></legend>
	<?php
		echo $this->Form->input('restaurant_id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('invoice_number');
		echo $this->Form->input('from_date');
		echo $this->Form->input('to_date');
		echo $this->Form->input('status');
		echo $this->Form->input('total_amount');
		echo $this->Form->input('paid_amount');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li>
			<?php
			echo $this->Html->link(__('List Invoices'), array('action' => 'index'));
			?>
		</li>
	</ul>
</div>
