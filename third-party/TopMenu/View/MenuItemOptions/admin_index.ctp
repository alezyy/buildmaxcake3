<?php


$this->Html->addCrumb(__('Locations'), array(
	'controller' => 'locations',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Location'), array(
	'controller' => 'locations',
	'action' => 'view',
	$location_id
));

$this->Html->addCrumb(__('Menus'), array(
	'controller' => 'menus',
	'action' => 'index',
	$location_id
));
$this->Html->addCrumb(__('View Menu'), array(
	'controller' => 'menus',
	'action' => 'view',
	$location_id,
	$menu_id
));
$this->Html->addCrumb(__('Edit Options'));
?>
<div class="menuItemOptions index span10">
	<h2><?php echo __('Menu Item Options'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($menuItemOptions as $menuItemOption): ?>
	<tr>
		<td><?php echo h($menuItemOption['MenuItemOption']['description']); ?>&nbsp;</td>
		<td><?php echo h($menuItemOption['MenuItemOption']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($menuItemOption['MenuItemOption']['name_fr']); ?>&nbsp;</td>
		<td><?php echo h($menuItemOption['MenuItemOption']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php
			echo $this->Html->link(
				__('View'),
				array(
					'action' => 'view',
					$location_id,
					$menu_id,
					$category_id,
					$menuItemOption['MenuItemOption']['id']
				)
			);
			?>
			<?php
			echo $this->Html->link(
				__('Edit'),
				array(
					'action' => 'edit',
					$location_id,
					$menu_id,
					$category_id,
					$menuItemOption['MenuItemOption']['id']
				)
			);
			?>
			<?php
			echo $this->Form->postLink(
				__('Delete'),
				array(
					'action' => 'delete',
					$location_id,
					$menu_id,
					$category_id,
					$menuItemOption['MenuItemOption']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $menuItemOption['MenuItemOption']['id'])
			);
			?>
			<?php
			echo $this->Html->link(
				'<i class="icon-arrow-up"></i>',
				array(
					'controller' => 'menu_item_options',
					'action' => 'move_up',
					'admin' => true,
					$location_id,
					$menuItemOption['Menu']['id'],
					$menuItemOption['MenuCategory']['id'],
					$menuItemOption['MenuItemOption']['id']
				),
				array(
					'escape' => false,
					'alt' => __('Move Up')
				)
			);

			echo $this->Html->link(
				'<i class="icon-arrow-down"></i>',
				array(
					'controller' => 'menu_item_options',
					'action' => 'move_down',
					'admin' => true,
					$location_id,
					$menuItemOption['Menu']['id'],
					$menuItemOption['MenuCategory']['id'],
					$menuItemOption['MenuItemOption']['id']
				),
				array(
					'escape' => false,
					'alt' => __('Move Down')
				)
			);
			?>
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
	<ul>
		<li>
			<?php
			echo $this->Html->link(
				__('New Option'),
				array(
					'action' => 'add',
					'admin' => true,
					$location_id,
					$menu_id,
					$category_id
				)
			);
			?>
		</li>
	</ul>
</div>
