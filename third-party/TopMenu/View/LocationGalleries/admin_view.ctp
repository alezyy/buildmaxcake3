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
$this->Html->addCrumb(__('Image Gallery'), array(
	'controller' => 'location_galleries',
	'action' => 'index',
	$location_id
));
$this->Html->addCrumb(__('View Image'));
?>
<div class="locationGalleries view span9">
<h2><?php echo __('Location Gallery'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($locationGallery['LocationGallery']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php
			echo $this->Html->link(
				$locationGallery['Location']['name'],
				array(
					'controller' => 'locations',
					'action' => 'view',
					$locationGallery['Location']['id']
				)
			);
		?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo $this->Image->out($locationGallery['LocationGallery']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Caption En'); ?></dt>
		<dd>
			<?php echo h($locationGallery['LocationGallery']['caption_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Caption Fr'); ?></dt>
		<dd>
			<?php echo h($locationGallery['LocationGallery']['caption_fr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span3 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php
			echo $this->Html->link(
				__('Edit Location Gallery'), 
				array(
					'action' => 'edit',
					$location_id,
					$locationGallery['LocationGallery']['id']
				)
			);
			?>
		</li>
		<li>
			<?php
			echo $this->Form->postLink(
				__('Delete Location Gallery'),
				array(
					'action' => 'delete',
					$location_id,
					$locationGallery['LocationGallery']['id']
				),
				null,
				__('Are you sure you want to delete # %s?', $locationGallery['LocationGallery']['id']));
			?>
		</li>
	
	</ul>
</div>
