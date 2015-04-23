<div class="slideshowImages view span9">
<h2><?php echo __('Slideshow Image'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($slideshowImage['SlideshowImage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image En'); ?></dt>
		<dd>
			<?php echo $this->Image->out($slideshowImage['SlideshowImage']['image_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image Fr'); ?></dt>
		<dd>
			<?php echo $this->Image->out($slideshowImage['SlideshowImage']['image_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($slideshowImage['SlideshowImage']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($slideshowImage['SlideshowImage']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description En'); ?></dt>
		<dd>
			<?php echo h($slideshowImage['SlideshowImage']['description_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description Fr'); ?></dt>
		<dd>
			<?php echo h($slideshowImage['SlideshowImage']['description_fr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span3">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Slideshow Image'), array('action' => 'edit', $slideshowImage['SlideshowImage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Slideshow Image'), array('action' => 'delete', $slideshowImage['SlideshowImage']['id']), null, __('Are you sure you want to delete # %s?', $slideshowImage['SlideshowImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Slideshow Images'), array('action' => 'index')); ?> </li>
	</ul>
</div>
