<?php
$this->Html->addCrumb(__('Location Redirects'), array(
	'controller' => 'location_redirects',
	'action' => 'index'
));
$this->Html->addCrumb(__('View Location Redirect'));
?>
<div class="locationRedirects view span8">
<h2><?php echo __('Location Redirect'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($locationRedirect['LocationRedirect']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($locationRedirect['Location']['name'], array('controller' => 'locations', 'action' => 'view', $locationRedirect['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Old Url'); ?></dt>
		<dd>
			<?php echo h($locationRedirect['LocationRedirect']['old_url']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Location Redirect'), array('action' => 'edit', $locationRedirect['LocationRedirect']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Location Redirect'), array('action' => 'delete', $locationRedirect['LocationRedirect']['id']), null, __('Are you sure you want to delete %s?', $locationRedirect['LocationRedirect']['old_url'])); ?> </li>
	</ul>
</div>
