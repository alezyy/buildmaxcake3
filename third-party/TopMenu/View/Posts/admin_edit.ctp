<?php
$this->Html->addCrumb(__('Posts'), array(
	'controller' => 'posts',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('View Post'), array(
	'controller' => 'posts',
	'action' => 'view',
	$this->request->data['Post']['id'],
	'admin' => true
));
$this->Html->addCrumb(__('Edit Post'));
?>
<div class="posts form span10">
<?php echo $this->Form->create('Post'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Post'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Post.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('controller' => 'blog_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Category'), array('controller' => 'blog_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
