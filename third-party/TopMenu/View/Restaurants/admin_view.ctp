<?php
$this->Html->addCrumb(__('Restaurants'), array(
	'controller' => 'restaurants',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb($restaurant_name);
?>
<div class="restaurants view span8">
<h2><?php echo __('Restaurant'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['name']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Logo'); ?></dt>
		<dd>
			<?php
				echo $this->Image->out(
					$restaurant['Restaurant']['logo'],
					'64x64'
				);
			?>
		</dd>
		

		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($restaurant['Restaurant']['url']); ?>
			&nbsp;
		</dd>

	</dl>
</div>
<div class="actions pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Restaurant'), array('action' => 'edit', $restaurant['Restaurant']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Restaurant'), array('action' => 'delete', $restaurant['Restaurant']['id']), null, __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id'])); ?> </li>
		<li>
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
		</li>
		<li>
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
		</li>
		<li>
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
		</li>
	</ul>
</div>
