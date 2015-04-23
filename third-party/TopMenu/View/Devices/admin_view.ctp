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
$this->Html->addCrumb(__('Devices'), array(
	'controller' => 'devices',
	'action' => 'location_index',
	$location_id
));
$this->Html->addCrumb(__('View Device'));
?>
<div class="devices view span8">
<h2><?php echo __('Device'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($device['Device']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php
			echo $this->Html->link(
				$device['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$location_id,
					$device['Location']['id']
				)
			);
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($device['Device']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($device['Device']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Connection'); ?></dt>
		<dd>
			<?php echo h($device['Device']['last_connection']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Device'), array('action' => 'edit', $location_id, $device['Device']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Device'), array('action' => 'delete', $location_id, $device['Device']['id']), null, __('Are you sure you want to delete # %s?', $device['Device']['id'])); ?> </li>
	</ul>
</div>
