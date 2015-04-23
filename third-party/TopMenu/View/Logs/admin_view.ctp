<div class="logs view span10">
<h2><?php echo __('Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($log['Log']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uri'); ?></dt>
		<dd>
			<?php echo h($log['Log']['uri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Method'); ?></dt>
		<dd>
			<?php echo h($log['Log']['method']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Params'); ?></dt>
		<dd>
			<?php echo h($log['Log']['params']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Api Key'); ?></dt>
		<dd>
			<?php echo h($log['Log']['api_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip Address'); ?></dt>
		<dd>
			<?php echo h($log['Log']['ip_address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time'); ?></dt>
		<dd>
			<?php echo h($log['Log']['time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Authorized'); ?></dt>
		<dd>
			<?php echo h($log['Log']['authorized']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Logs'), array('action' => 'index')); ?> </li>
	</ul>
</div>
