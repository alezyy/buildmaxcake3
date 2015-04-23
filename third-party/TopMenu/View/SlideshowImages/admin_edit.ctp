<div class="slideshowImages form">
<?php echo $this->Form->create('SlideshowImage', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Slideshow Image'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Image->input('image_en');
		echo $this->Image->input('image_fr');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('description_en');
		echo $this->Form->input('description_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SlideshowImage.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SlideshowImage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Slideshow Images'), array('action' => 'index')); ?></li>
	</ul>
</div>
