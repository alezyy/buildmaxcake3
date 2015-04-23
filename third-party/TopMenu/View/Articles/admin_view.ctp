<div class="articles view span8">
<h2><?php echo __('Article'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($article['Article']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($article['Article']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($article['Article']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content En'); ?></dt>
		<dd>
			<?php echo $article['Article']['content_en']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Fr'); ?></dt>
		<dd>
			<?php echo $article['Article']['content_fr']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Published'); ?></dt>
		<dd>
			<?php echo h($article['Article']['published']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($article['Article']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name En'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Name Fr'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description En'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_description_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Description Fr'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_description_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords En'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_keywords_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meta Keywords Fr'); ?></dt>
		<dd>
			<?php echo h($article['Article']['meta_keywords_fr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Article'), array('action' => 'edit', $article['Article']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Article'), array('action' => 'delete', $article['Article']['id']), null, __('Are you sure you want to delete # %s?', $article['Article']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('action' => 'add')); ?> </li>
	</ul>
</div>
