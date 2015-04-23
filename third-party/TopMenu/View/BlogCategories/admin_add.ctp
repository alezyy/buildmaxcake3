<div class="blogCategories form span8">
<?php echo $this->Form->create('BlogCategory'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Blog Category'); ?></legend>
	<?php
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('meta_name_en');
		echo $this->Form->input('meta_name_fr');
		echo $this->Form->input('meta_description_en');
		echo $this->Form->input('meta_description_fr');
		echo $this->Form->input('meta_keywords_en');
		echo $this->Form->input('meta_keywords_fr');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>