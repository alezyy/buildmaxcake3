<div class="articles form span8">
<?php echo $this->Form->create('Article'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Article'); ?></legend>
	<?php
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('content_en');
		echo $this->Form->input('content_fr');
		echo $this->Form->input('published');
		echo $this->Form->input('meta_name_en');
		echo $this->Form->input('meta_name_fr');
		echo $this->Form->input('meta_description_en');
		echo $this->Form->input('meta_description_fr');
		echo $this->Form->input('meta_keywords_en');
		echo $this->Form->input('meta_keywords_fr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
