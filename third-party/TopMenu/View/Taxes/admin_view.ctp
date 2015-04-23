<div class="taxes view span10">
<h2><?php echo __('Tax'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['country']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Province'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['province']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Percentage'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['percentage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Compound'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['is_compound']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name En'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Fr'); ?></dt>
		<dd>
			<?php echo h($tax['Tax']['name_fr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tax'), array('action' => 'edit', $tax['Tax']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Taxes'), array('action' => 'index')); ?> </li>

	</ul>
</div>
