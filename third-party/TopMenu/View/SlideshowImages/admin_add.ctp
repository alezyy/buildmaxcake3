<div class="slideshowImages form span9">
<?php echo $this->Form->create('SlideshowImage', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Slideshow Image'); ?></legend>
	<?php
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
<div class="actions span3">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Slideshow Images'), array('action' => 'index')); ?></li>
	</ul>
</div>
