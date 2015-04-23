<div class="blogCategories form span8">
<?php echo $this->Form->create('BlogCategory'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Blog Category'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BlogCategory.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('BlogCategory.id'))); ?></li>
	</ul>
</div>
