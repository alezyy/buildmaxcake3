<?php
$this->Html->addCrumb(__('Restaurants'), array(
	'controller' => 'restaurants',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(
	$restaurant_name,
	array(
		'controller' => 'restaurants',
		'action'     => 'view',
		'admin'      => true,
		$restaurant_id
	)
);
$this->Html->addCrumb(__('Domains'), array(
	'controller' => 'domains',
	'action' => 'index',
	$restaurant_id,
));
$this->Html->addCrumb(__('View Domain'));
?>
<div class="domains view span10">
<h2><?php echo __('Domain'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Restaurant'); ?></dt>
		<dd>
			<?php echo $this->Html->link($domain['Restaurant']['name'], array('controller' => 'restaurants', 'action' => 'view', $domain['Restaurant']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Domain Type'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['domain_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Domain Name'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['domain_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Main Website'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['main_website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Theme'); ?></dt>
		<dd>
			<?php echo $this->Html->link($domain['Theme']['name'], array('controller' => 'themes', 'action' => 'view', $domain['Theme']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Theme Values'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['theme_values']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($domain['Domain']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Domain'), array('action' => 'edit', $restaurant_id, $domain['Domain']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Domain'), array('action' => 'delete', $restaurant_id, $domain['Domain']['id']), null, __('Are you sure you want to delete # %s?', $domain['Domain']['id'])); ?> </li>
	</ul>
</div>
