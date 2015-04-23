<div class="contests view span8">
<h2><?php echo __('Contest'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telephone'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['telephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Of Birth'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['date_of_birth']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sector'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['sector']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Restaurant'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['restaurant']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Registration Date'); ?></dt>
		<dd>
			<?php echo h($contest['Contest']['registration_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contest'), array('action' => 'edit', $contest['Contest']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contest'), array('action' => 'delete', $contest['Contest']['id']), null, __('Are you sure you want to delete # %s?', $contest['Contest']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contest'), array('action' => 'add')); ?> </li>
	</ul>
</div>
