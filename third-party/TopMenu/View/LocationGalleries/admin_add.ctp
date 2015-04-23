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
$this->Html->addCrumb(__('Add Image'));
?>
<div class="locationGalleries form span10">
<?php echo $this->Form->create('LocationGallery', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Image to Gallery'); ?></legend>
	<?php
		echo $this->Image->input('image');
		echo $this->Form->input('caption_en');
		echo $this->Form->input('caption_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li>
			<?php
			echo $this->Html->link(
				__('List Location Gallery'), 
				array(
					'action' => 'index',
					$location_id
				)
			);
			?>
		</li>
	</ul>
</div>
