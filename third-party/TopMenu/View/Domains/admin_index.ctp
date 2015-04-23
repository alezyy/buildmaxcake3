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
$this->Html->addCrumb(__('Domains'));
?>
<div class="domains index span10">
	<h2><?php echo __('Domains'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('restaurant_id'); ?></th>
			<th><?php echo $this->Paginator->sort('domain_type'); ?></th>
			<th><?php echo $this->Paginator->sort('domain_name'); ?></th>
			<th><?php echo $this->Paginator->sort('main_website'); ?></th>
			<th><?php echo $this->Paginator->sort('theme_id'); ?></th>
			<th><?php echo $this->Paginator->sort('theme_values'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($domains as $domain): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($domain['Restaurant']['name'], array('controller' => 'restaurants', 'action' => 'view', $domain['Restaurant']['id'])); ?>
		</td>
		<td><?php echo h($domain['Domain']['domain_type']); ?>&nbsp;</td>
		<td><?php echo h($domain['Domain']['domain_name']); ?>&nbsp;</td>
		<td><?php echo h($domain['Domain']['main_website']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($domain['Theme']['name'], array('controller' => 'themes', 'action' => 'view', $domain['Theme']['id'])); ?>
		</td>
		<td><?php echo h($domain['Domain']['theme_values']); ?>&nbsp;</td>
		<td><?php echo h($domain['Domain']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $restaurant_id, $domain['Domain']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="pagination">
		<ul>
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</ul>
	</div>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('New Domain'), array('action' => 'add', $restaurant_id)); ?></li>
	</ul>
</div>
