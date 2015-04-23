<?php
$this->Html->addCrumb(__('Invoices'), array(
	'controller' => 'invoices',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Invoice'), array(
	'controller' => 'invoices',
	'action' => 'view',
	$this->Form->value('Invoice.id')
));
$this->Html->addCrumb(__('Edit Invoice'));
?>
<div class="invoices form span10">
<?php echo $this->Form->create('Invoice'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Invoice'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
			echo $this->Form->postLink(
				__('Delete'),
				array(
					'action' => 'delete',
					$this->Form->value('Invoice.id')
				),
				null,
				__('Are you sure you want to delete # %s?', $this->Form->value('Invoice.id'))
			);
			?>
		</li>
		<li>
			<?php
			echo $this->Html->link(__('List Invoices'), array('action' => 'index'));
			?>
		</li>
	</ul>
</div>
