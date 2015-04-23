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

$this->Html->addCrumb(__('Location Devices'));
?>
<div class="devices index span11">
	<h2><?php echo __('Location Devices'); ?></h2>

	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo __('Description'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('timeout'); ?></th>
			<th><?php echo $this->Paginator->sort('last_connection'); ?></th>
			<th><?php echo $this->Paginator->sort('difference', __('Status')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($devices as $device): ?>
	<tr>
		<td>
			<?php 
			echo $this->Html->link(
				$device['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$device['Location']['id'],
					$device['Location']['id']
				)
			);
			?>
		</td>
		<td><?php echo h($device['Device']['description']); ?>&nbsp;</td>
		<td><?php echo h($device['Device']['username']); ?>&nbsp;</td>
		<td><?php echo h($device['Device']['timeout']); ?>&nbsp;</td>
		<td>
			<?php
			echo $this->Date->formatDate($device['Device']['last_connection']);
			?>
		</td>
		<td>
			<?php
			$status = @$device['Device']['online'];
			switch ($status) {
				case true:
					$type = 'success';
					$text = __('Online');
				break;

				default:
					$type = 'error';
					$text = __('Offline');
				break;
			}
			echo $this->Bootstrap->badge($text, $type);
			?>
		</td>
		<td class="actions">
			<?php 
				echo $this->Html->link(
					__('View'),
					array(
						'action' => 'view',
						$device['Location']['id'],
						$device['Device']['id']
					)
				);
				?>
			<?php
			echo $this->Html->link(
				__('Edit'),
				array(
					'action' => 'edit',
					$device['Location']['id'],
					$device['Device']['id']
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
<div class="actions pull-right">
	<ul class="nav nav-tabs nav-stacked">
		<li>
			<?php
			echo $this->Html->link(
				__('New'),
				array(
					'action' => 'add',
					$location_id
				)
			);
			?>
		</li>
	</ul>
</div>
