<?php
$this->Html->addCrumb(__('Posts'), array(
	'controller' => 'posts',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('Add Post'));
?>
<div class="posts form span10">
<?php echo $this->Form->create('Post'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Post'); ?></legend>
	<?php
		echo $this->Form->input('blog_category_id');
		echo $this->Form->input('name_en');
		echo $this->Form->input('name_fr');
		echo $this->Form->input('content_en');
		echo $this->Form->input('content_fr');
		echo $this->Form->input('published');
		echo $this->Form->input('post_date');
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
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?></li>
	</ul>
</div>
