<?php
$this->Html->addCrumb(__('Restaurants'));
?>
<div class="restaurants index span10">
	<h2><?php echo __('Restaurants'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan='8'>

			<?php 
			echo $this->Form->create('Query');
			echo $this->Form->input(
				'search',
				array(
					'label' => false,
					'placeholder' => __('Search'),
					'append' => $this->Form->submit(
						__('Search'),
						array(
							'div' => false,
							'class' => 'btn'
						)
					),
					'class' => 'search',
					'div' => false
				)
			);
			echo $this->Form->end();
			?>
		</td>
	</tr>
	<tr>
			<th><?php echo __('Logo'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th></th>
			<th></th>
			<th></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($restaurants as $restaurant): ?>
	<tr>
		<td><?php echo $this->Image->out($restaurant['Restaurant']['logo']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['name']); ?>&nbsp;</td>
		
		<td>
			<?php
			echo $this->Html->link(
				__('Locations'),
				array(
					'controller' => 'locations',
					'action' => 'index',
					$restaurant['Restaurant']['id']
				)
			);
			?>
		</td>

		<td>
			<?php
			echo $this->Html->link(
				__('Domains (Platform)'),
				array(
					'controller' => 'domains',
					'action' => 'index',
					$restaurant['Restaurant']['id']
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $this->Html->link(
				__('Global Menu'),
				array(
					'controller' => 'menus',
					'action' => 'index',
					$restaurant['Restaurant']['id'],
					0
				)
			);
			?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $restaurant['Restaurant']['id'])); ?>
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
<div class="actions pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('New Restaurant'), array('action' => 'add')); ?></li>
	</ul>
</div>
