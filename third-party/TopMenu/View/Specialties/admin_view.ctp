<div class="specialties view">
<h2><?php echo __('Specialty'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['name_fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['url']); ?>
			&nbsp;
		</dd>

	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Specialty'), array('action' => 'edit', $specialty['Specialty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Specialty'), array('action' => 'delete', $specialty['Specialty']['id']), null, __('Are you sure you want to delete # %s?', $specialty['Specialty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('action' => 'index')); ?> </li>
	</ul>
</div>
