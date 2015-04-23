<?php
$this->Html->addCrumb(__('Location Redirects'));
?>
<div class="locationRedirects index span8">
	<h2><?php echo __('Location Redirects'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan='3'>

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
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('old_url'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($locationRedirects as $locationRedirect): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($locationRedirect['Location']['name'], array('controller' => 'locations', 'action' => 'view', $locationRedirect['Location']['id'])); ?>
		</td>
		<td><?php echo h($locationRedirect['LocationRedirect']['old_url']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $locationRedirect['LocationRedirect']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $locationRedirect['LocationRedirect']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $locationRedirect['LocationRedirect']['id']), null, __('Are you sure you want to delete %s?', $locationRedirect['LocationRedirect']['old_url'])); ?>
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
		<li><?php echo $this->Html->link(__('New Location Redirect'), array('action' => 'add')); ?></li>
	</ul>
</div>
