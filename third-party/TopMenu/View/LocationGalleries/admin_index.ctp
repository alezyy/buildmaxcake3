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
$this->Html->addCrumb(__('Image Gallery'));
?>
<div class="locationGalleries index span10">
	<h2><?php echo __('Location Galleries'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('image'); ?></th>
		<th><?php echo $this->Paginator->sort('location_id'); ?></th>
		<th><?php echo $this->Paginator->sort('caption_en'); ?></th>
		<th><?php echo $this->Paginator->sort('caption_fr'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($locationGalleries as $locationGallery): ?>
	<tr>
		<td><?php echo $this->Image->out($locationGallery['LocationGallery']['image']); ?>&nbsp;</td>
		<td>
			<?php
			echo $this->Html->link(
			$locationGallery['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$location_id,
					$locationGallery['Location']['id']
				)
			);
			?>
		</td>
		<td><?php echo h($locationGallery['LocationGallery']['caption_en']); ?>&nbsp;</td>
		<td><?php echo h($locationGallery['LocationGallery']['caption_fr']); ?>&nbsp;</td>
		<td class="actions">
			<?php
			echo $this->Html->link(
				__('View'),
				array(
					'action' => 'view',
					$location_id,
					$locationGallery['LocationGallery']['id']
				)
			);
			echo $this->Html->link(
				__('Edit'),
				array(
					'action' => 'edit',
					$location_id,
					$locationGallery['LocationGallery']['id']
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
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php
			echo $this->Html->link(__('New Image'), array('action' => 'add', $location_id));
			?>
		</li>
	</ul>
</div>
