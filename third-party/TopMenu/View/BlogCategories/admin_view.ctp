<div class="blogCategories view span8">
<h2><?php echo __('Blog Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name En'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name Fr'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description En'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_description_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description Fr'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_description_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords En'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_keywords_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords Fr'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['meta_keywords_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($blogCategory['BlogCategory']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Blog Category'), array('action' => 'edit', $blogCategory['BlogCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Blog Category'), array('action' => 'delete', $blogCategory['BlogCategory']['id']), null, __('Are you sure you want to delete # %s?', $blogCategory['BlogCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('action' => 'index')); ?> </li>
	</ul>
</div>