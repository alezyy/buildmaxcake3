<?php
$this->Html->addCrumb(__('Invoices'), array(
	'controller' => 'invoices',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Invoice'));
?>
<div class="invoices view span9">
<h2><?php echo __('Invoice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Restaurant'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoice['Restaurant']['name'], array('controller' => 'restaurants', 'action' => 'view', $invoice['Restaurant']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoice['Location']['name'], array('controller' => 'locations', 'action' => 'view', $invoice['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Number'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['invoice_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From Date'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['from_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To Date'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['to_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Amount'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['total_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid Amount'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['paid_amount']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span3 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php
			echo $this->Html->link(
				__('Edit Invoice'),
				array('action' => 'edit', $invoice['Invoice']['id'])
			);
			?>
		</li>
		<li>
			<?php
			echo $this->Form->postLink(
				__('Delete Invoice'),
				array(
					'action' => 'delete',
					$invoice['Invoice']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $invoice['Invoice']['id'])
			);
			?>
		</li>
		<li>
			<?php echo $this->Html->link(__('List Invoices'), array('action' => 'index')); ?>
		</li>
	</ul>
</div>
