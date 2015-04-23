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
$this->Html->addCrumb(__('Edit Image'));
?>
<div class="locationGalleries form span9">
<?php echo $this->Form->create('LocationGallery', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Location Gallery'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Image->input('image');
		echo $this->Form->input('caption_en');
		echo $this->Form->input('caption_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span3 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php
			echo $this->Html->link(
				__('List Location Galleries'), 
				array(
					'action' => 'index',
					$location_id
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
					$this->Form->value('LocationGallery.id')
				),
				null,
				__('Are you sure you want to delete # %s?', $this->Form->value('LocationGallery.id')));
			?>
		</li>
	</ul>
</div>
