<?php

$this->Html->addCrumb(__('Cuisines'));
?>
<div class="cuisines index span8">
	<h2><?php echo __('Cuisines'); ?></h2>
	<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name_en'); ?></th>
			<th><?php echo $this->Paginator->sort('name_fr'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cuisines as $cuisine): ?>
	<tr>
		<td><?php echo h($cuisine['Cuisine']['name_en']); ?>&nbsp;</td>
		<td><?php echo h($cuisine['Cuisine']['name_fr']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cuisine['Cuisine']['id'])); ?>
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
<div class="actions span2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><?php echo $this->Html->link(__('New Cuisine'), array('action' => 'add')); ?></li>
	</ul>
</div>
