<div class="posts view span10">
<h2><?php echo __('Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Blog Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['BlogCategory']['name_fr'], array('controller' => 'blog_categories', 'action' => 'view', $post['BlogCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($post['Post']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($post['Post']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content En'); ?></dt>
		<dd>
			<?php echo h($post['Post']['content_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Fr'); ?></dt>
		<dd>
			<?php echo h($post['Post']['content_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Published'); ?></dt>
		<dd>
			<?php echo h($post['Post']['published']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Date'); ?></dt>
		<dd>
			<?php echo h($post['Post']['post_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($post['Post']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name En'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name Fr'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description En'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_description_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description Fr'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_description_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords En'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_keywords_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords Fr'); ?></dt>
		<dd>
			<?php echo h($post['Post']['meta_keywords_fr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Post'), array('action' => 'edit', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Post'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?> </li>
	</ul>
</div>
