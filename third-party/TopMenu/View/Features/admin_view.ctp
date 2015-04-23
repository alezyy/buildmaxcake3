<div class="features view span9">
<h2><?php echo __('Feature'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($feature['Feature']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($feature['Feature']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($feature['Feature']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($feature['Feature']['url']); ?>
			&nbsp;
		</dd>

	</dl>
</div>
<div class="actions span3">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Feature'), array('action' => 'edit', $feature['Feature']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Feature'), array('action' => 'delete', $feature['Feature']['id']), null, __('Are you sure you want to delete # %s?', $feature['Feature']['id'])); ?> </li>
	</ul>
</div>
