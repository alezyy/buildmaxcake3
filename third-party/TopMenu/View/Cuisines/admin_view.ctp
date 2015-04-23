<?php
$this->Html->addCrumb(__('Cuisines'), array(
	'controller' => 'cuisines',
	'action' => 'index',
	'admin' => true
));
$this->Html->addCrumb(__('View Cuisine'));
?>
<div class="cuisines view span8">
<h2><?php echo __('Cuisine'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cuisine['Cuisine']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($cuisine['Cuisine']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($cuisine['Cuisine']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description EN'); ?></dt>
		<dd>
			<?php echo $cuisine['Cuisine']['description_en']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description FR'); ?></dt>
		<dd>
			<?php echo $cuisine['Cuisine']['description_fr']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Cuisine'), array('action' => 'edit', $cuisine['Cuisine']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cuisine'), array('action' => 'delete', $cuisine['Cuisine']['id']), null, __('Are you sure you want to delete # %s?', $cuisine['Cuisine']['id'])); ?> </li>
	</ul>
</div>
