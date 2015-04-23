<div class="specialties index span10">
	<h2><?php echo __('Specialties'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan='6'>

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
			<th></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($specialties as $specialty): ?>
	<tr>
		<td><?php echo $this->Image->out($specialty['Specialty']['image']); ?></td>
		<td><?php echo h($specialty['Specialty']['name_fr']); ?>&nbsp;</td>
		<td><?php echo h($specialty['Specialty']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($specialty['Specialty']['url']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $specialty['Specialty']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $specialty['Specialty']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $specialty['Specialty']['id']), null, __('Are you sure you want to delete # %s?', $specialty['Specialty']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Specialty'), array('action' => 'add')); ?></li>
	</ul>
</div>
