<?php
$this->Html->addCrumb(__('Device Overview'));
?>
<div class="devices index span10">
	<h2><?php echo __('Device Dashboard'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo __('Description'); ?></th>
			<th><?php echo $this->Paginator->sort('last_connection'); ?></th>
			<th><?php echo $this->Paginator->sort('difference', __('Status')); ?></th>
			<th><?php echo $this->Paginator->sort('timeout'); ?></th>
	</tr>
	<?php foreach ($devices as $device): ?>
	<tr>
        <td><?php echo $device['Device']['line_number']; ?></td>
		<td>
			<?php 
			echo $this->Html->link(
				$device['Location']['name'],
				array(
					'controller' => 'devices',
					'action' => 'location_index',
					$device['Location']['id']
				)
			);
			?>
            <br/>
			<?php echo h($device['Location']['phone']); ?>
		</td>
		<td><?php echo h($device['Device']['description']); ?>&nbsp;</td>
		<td>
			<?php
			echo $this->Time->i18nFormat(
				strtotime($device['Device']['last_connection']),
				"%a %d %b %Y - %k:%M:%S",
				false,
				'America/Montreal'
			);
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
		<td>
			<?php
			echo ($device['Device']['timeout'] > 250)? "☎": __('WiFi');
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
				__('Broadcast'),
				array(
					'action' => 'broadcast',
				)
			);
			?>
		</li>
	</ul>
</div>
