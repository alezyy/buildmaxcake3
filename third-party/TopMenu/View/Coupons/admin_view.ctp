<div class="coupons view span8">
<h2><?php echo __('Coupon'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($coupon['User']['id'], array('controller' => 'users', 'action' => 'view', $coupon['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($coupon['Location']['name'], array('controller' => 'locations', 'action' => 'view', $coupon['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coupon Code'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['coupon_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Type'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['discount_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Created'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['date_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Experation Date'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['experation_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coupon Type'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['coupon_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Frequency'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['frequency']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Frequency Used'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['frequency_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($coupon['Coupon']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('Edit Coupon'), array('action' => 'edit', $coupon['Coupon']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Coupon'), array('action' => 'delete', $coupon['Coupon']['id']), null, __('Are you sure you want to delete # %s?', $coupon['Coupon']['id'])); ?>
		</li>
	</ul>
</div>
