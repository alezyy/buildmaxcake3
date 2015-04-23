<div class="sectors index span10">
	<h2><?php echo __('Sectors'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
		<tr>
		<td colspan='5'>

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
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
            <th class="actions" style="min-width: 90px; text-align: justify"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sectors as $sector): ?>
	<tr>
		<td><?php echo h($sector['Sector']['name_fr']); ?>&nbsp;</td>
		<td><?php echo h($sector['Sector']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($sector['Sector']['code']); ?>&nbsp;</td>
		<td><?php echo h($sector['Sector']['url']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sector['Sector']['id'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sector['Sector']['id']), null, __('Are you sure you want to delete # %s?', $sector['Sector']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sector'), array('action' => 'add')); ?></li>
	</ul>
</div>
