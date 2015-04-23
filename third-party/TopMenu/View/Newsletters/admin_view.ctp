<div class="newsletters view span8">
<h2><?php echo __('Newsletter'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telephone'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['telephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['postal_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Newsletter'), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Newsletter'), array('action' => 'delete', $newsletter['Newsletter']['id']), null, __('Are you sure you want to delete # %s?', $newsletter['Newsletter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter'), array('action' => 'add')); ?> </li>
	</ul>
</div>
