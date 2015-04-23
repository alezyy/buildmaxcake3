<div class="slideshowImages index span9">
	<h2><?php echo __('Slideshow Images'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>	
		<td colspan='9'>
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
			<th><?php echo __('Image-EN'); ?></th>
			<th><?php echo __('Image-FR'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($slideshowImages as $slideshowImage): ?>
	<tr>
		<td><?php echo $this->Image->out($slideshowImage['SlideshowImage']['image_en']); ?>&nbsp;</td>
		<td><?php echo $this->Image->out($slideshowImage['SlideshowImage']['image_fr']); ?>&nbsp;</td>
		<td><?php echo h($slideshowImage['SlideshowImage']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($slideshowImage['SlideshowImage']['name_fr']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $slideshowImage['SlideshowImage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $slideshowImage['SlideshowImage']['id'])); ?>
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
<div class="actions span3">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Slideshow Image'), array('action' => 'add')); ?></li>
	</ul>
</div>
