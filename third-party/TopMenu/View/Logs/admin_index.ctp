<div class="logs index span10">
	<h2><?php echo __('Logs'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<td colspan='7'>
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
	<tr>
			<th><?php echo $this->Paginator->sort('uri'); ?></th>
			<th><?php echo $this->Paginator->sort('method'); ?></th>
			<th><?php echo $this->Paginator->sort('api_key'); ?></th>
			<th><?php echo $this->Paginator->sort('ip_address'); ?></th>
			<th><?php echo $this->Paginator->sort('time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($logs as $log): ?>
	<tr>
		<td><?php echo h($log['Log']['uri']); ?>&nbsp;</td>
		<td><?php echo h($log['Log']['method']); ?>&nbsp;</td>
		<td><?php echo h($log['Log']['api_key']); ?>&nbsp;</td>
		<td><?php echo h($log['Log']['ip_address']); ?>&nbsp;</td>
		<td><?php echo date('Y-m-d H:i:s', $log['Log']['time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $log['Log']['id'])); ?>
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