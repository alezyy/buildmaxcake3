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
$this->Html->addCrumb(__('Edit Options'), array(
	'controller' => 'menu_item_options',
	'action' => 'index',
	$location_id,
	$menu_id,
	$category_id
));
$this->Html->addCrumb(__('View Option'));
?>
<div class="menuItemOptions view">
	<h2><?php echo __('Menu Item Option'); ?></h2>
	<dl>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Multiselect'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['multiselect']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Required'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['required']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number Of Free Values'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['number_of_free_values']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Half And Half'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['half_and_half']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($menuItemOption['MenuItemOption']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<ul class="nav nav-tabs">
	<li class="pull-right">
		<?php
		echo $this->Html->link(__('Add Value'), array(
			'controller' => 'menu_item_option_values',
			'action' => 'add',
			$location_id,
			$menu_id,
			$category_id,
			$menuItemOption['MenuItemOption']['id']

		));
		?>
	</li>
</ul>
<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<thead>
		<th><?php echo __('Name En'); ?></th>
		<th><?php echo __('Name Fr'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Action'); ?></th>
	</thead>
	<tbody>
		<?php foreach ($menuItemOptionValues as $optionValue): ?>
		<tr>
			<td><?php echo h($optionValue['MenuItemOptionValue']['name_en']); ?></td>
			<td><?php echo h($optionValue['MenuItemOptionValue']['name_fr']); ?></td>
			<td><?php echo $this->Number->currency($optionValue['MenuItemOptionValue']['price']); ?></td>
			<td><?php echo h($optionValue['MenuItemOptionValue']['status']); ?></td>
			<td>
				<?php
				echo $this->Html->link(
					__('Edit'),
					array(
						'controller' => 'menu_item_option_values',
						'action' => 'edit',
						$location_id,
						$menu_id,
						$category_id,
						$menuItemOption['MenuItemOption']['id'],
						$optionValue['MenuItemOptionValue']['id']
					)
				);
				?>

				<?php
				echo $this->Form->postLink(
				__('Delete'),
				array(
					'controller' => 'menu_item_option_values',
					'action' => 'delete',
					$location_id,
					$menu_id,
					$category_id,
					$menuItemOption['MenuItemOption']['id'],
					$optionValue['MenuItemOptionValue']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $optionValue['MenuItemOptionValue']['id'])
			);
				?>
				<?php
				echo $this->Html->link(
					'<i class="icon-arrow-up"></i>',
					array(
						'controller' => 'menu_item_option_values',
						'action' => 'move_up',
						'admin' => true,
						$location_id,
						$menu_id,
						$category_id,
						$menuItemOption['MenuItemOption']['id'],
						$optionValue['MenuItemOptionValue']['id']
					),
					array(
						'escape' => false,
						'alt' => __('Move Up')
					)
				);

				echo $this->Html->link(
					'<i class="icon-arrow-down"></i>',
					array(
						'controller' => 'menu_item_option_values',
						'action' => 'move_down',
						'admin' => true,
						$location_id,
						$menu_id,
						$category_id,
						$menuItemOption['MenuItemOption']['id'],
						$optionValue['MenuItemOptionValue']['id']
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
	</tbody>

</table>