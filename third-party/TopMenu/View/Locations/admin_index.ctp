<?php
$this->Html->addCrumb(__('Locations'));
?>
<div class="locations index span10">
	<h2><?php echo __('Locations'); ?></h2>
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
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($locations as $location): ?>
	<tr>        
        <td><?php echo $this->Image->out($location['Location']['logo'], '64x64', true, false, false); ?>&nbsp;</td>
		<td>
			<?php
			echo h($location['Location']['name']);
			if ($location['Location']['test_mode']) {
				echo ' <i class="icon-warning-sign"></i>';
				echo __('TEST MODE');
			}
			?>
		</td>

		<td>
			<?php echo $this->Html->link(__('Printers'), array('controller' => 'devices', 'action' => 'location_index', $location['Location']['id'])); ?>
		</td>

		<td>
			<?php echo $this->Html->link(__('Menu'), array('controller' => 'menus', 'action' => 'index', $location['Location']['id'])); ?>
		</td>
		<td>
			<?php
			$status = $location['Location']['status'];
			switch ($status) {
				case 'active':
					$type = 'success';
					$text = __('Active');
				break;

				default:
					$type = 'error';
					$text = __('Inactive');
				break;
			}
			echo $this->Bootstrap->badge($text, $type);
			?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $location['Location']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Location'), array('action' => 'add')); ?></li>
		
	</ul>
</div>
