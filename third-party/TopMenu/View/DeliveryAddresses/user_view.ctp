<div class="large">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Delivery addresses'); ?></h1>
		</div>
	</div>
	<div class="location_view">
		<div class="orders index">   
			<table class="table table-striped table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>	
					<th><?php echo $this->Paginator->sort('phone'); ?></th>	
					<th><?php echo $this->Paginator->sort('address'); ?></th>
					<th><?php echo $this->Paginator->sort('address2'); ?></th>
					<th><?php echo $this->Paginator->sort('cross_street'); ?></th>	
					<th><?php echo $this->Paginator->sort('city'); ?></th>
					<th><?php echo $this->Paginator->sort('postal_code'); ?></th>	
					<th class="actions"><?php echo __('Actions'); ?></th>


				</tr>

				<?php foreach ($address as $item): ?>


					<tr>
						<td><?php echo $item['DeliveryAddress']['name']; ?></td>
						<td><?php echo $item['DeliveryAddress']['phone']; ?></td>
						<td><?php echo $item['DeliveryAddress']['address']; ?></td>
						<td><?php echo $item['DeliveryAddress']['address2']; ?></td>
						<td><?php echo $item['DeliveryAddress']['cross_street']; ?></td>
						<td><?php echo $item['DeliveryAddress']['city']; ?></td>
						<td><?php echo $item['DeliveryAddress']['postal_code']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('Edit'), array('controller' => 'delivery_addresses', 'action' => 'user_edit', $item['DeliveryAddress']['id'])); ?>			
					<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'user_delete', $item['DeliveryAddress']['id']), null, __('Are you sure you want to delete this address?', $item['DeliveryAddress']['id'])); ?></li>
					</td>

					</tr>
				<?php endforeach; ?>
			</table>
			<p>
				<?php
				echo $this->Paginator->counter(array(
					'format' => __('Page') . '{:page}' . __(' of ') . ' {:pages},' . __(' showing') . ' {:current}' . __(' records out of ') . ' {:count}' . __(' total, starting on record ') . ' {:start},' . __(' ending on ') . '{:end}'
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

			<!-- Edit Links-->
			<?php
			echo $this->Html->link(__("Edit Profile"), array(
				'controller' => 'profiles',
				'action' => 'edit'), array('class' => 'edit'));
			?>
			&nbsp;|&nbsp;

			<?php
			echo $this->Html->link(__("My Account"), array(
				'controller' => 'users',
				'action' => 'my_account'), array('class' => 'edit'));
			?>   
			&nbsp;|&nbsp;

			<?php
			echo $this->Html->link(__("Add delivery address"), array(
				'controller' => 'delivery_addresses',
				'action' => 'user_add'), array('class' => 'edit'));
			?>   
		</div>
	</div>
</div>