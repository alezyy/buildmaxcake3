<div class="posts index span10">
	<h2><?php echo __('Posts'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover"  cellpadding="0" cellspacing="0">
	<tr>
		<td colspan='7'>

			<?php 
			echo $this->Form->create('Query');
			echo $this->Form->input(
				'search',
				array(
					'label' => false,
					'placeholder' => __('Search'),
					'append' => $this->Form->submit(
						__('Search'),
						array(
							'div' => false,
							'class' => 'btn'
						)
					),
					'class' => 'search',
					'div' => false
				)
			);
			echo $this->Form->end();
			?>
		</td>
	</tr>
	<tr>
			<th><?php echo $this->Paginator->sort('blog_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th><?php echo $this->Paginator->sort('published'); ?></th>
			<th><?php echo $this->Paginator->sort('post_date'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($post['BlogCategory']['name_fr'], array('controller' => 'blog_categories', 'action' => 'view', $post['BlogCategory']['id'])); ?>
		</td>
		<td><?php echo h($post['Post']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['name_fr']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['published']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['post_date']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['url']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="pagination">
		<ul>
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</ul>
	</div>
</div>
<div class="actions span2 pull-right">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('controller' => 'blog_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Category'), array('controller' => 'blog_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
