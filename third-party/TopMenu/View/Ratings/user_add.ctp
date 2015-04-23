<div id="content_inner">
	<div class="other_center">
		<div class="gray_head_box">
			<div class="gray_head_heading">
				<?php echo __('Write your review'); ?>
			</div>
		</div>
		<div class="location_view">
			<?php echo $this->Form->create('Rating'); ?>		
			<table>
				<tbody>
					<tr>
						<td>
							<?php echo __('Rating: ') ?>
						</td>
						<td>
							<?php
							echo $this->Form->input('rating', array(
								'type' => 'range',
								'step' => '0.5',
								'no_div' => TRUE,
								'div' => FALSE,
								'label' => FALSE,
								'id' => 'backing4'));
							?>
							<div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false" data-rateit-ispreset="true"
								 data-rateit-min="1" data-rateit-max="5">
							</div>
						</td>
						<td rowspan="2" style="padding-left: 1em; vertical-align: top">
							<p class="strong">
								<?php echo __('Please offer a description of your experience for this order:') ?>
							</p>
							<table>
								<tr>
									<th style="padding-right: 1em; ">
										<?php echo __('Order number') ?>
									</th><td>
										<?php echo $order['Order']['id'] ?>
									</td>
								</tr>
								<tr>
									<th>
										<?php echo __('Restaurant') ?>
									</th><td>
										<?php echo $location_name['Location']['name']; ?>
									</td>
								</tr>
								<tr>
									<th>
										<?php echo __('Ordered on') ?>
									</th><td>
										<?php echo $this->Date->formatDate($order['Order']['created']); ?>
									</td>
								</tr>
								<tr>
									<th><?php echo __('Items') ?></th>
									<td></td>
								<?php foreach ($order['OrderDetail'] as $od) { ?>
									<tr>
										<td></td>
										<td><?php echo $od['name'] ?></td>
									</tr>

								<?php } ?>
							</table>
						</td>
					</tr><tr>
						<td colspan="2">
							<?php echo __('Comment: ') ?>
							<br/>

							<?php
							echo $this->Form->input('review', array(
								'div' => false,
								'no_div' => TRUE,
								'label' => FALSE));
							?>
						</td>
					</tr>					
				</tbody>
				<tfoot style="text-align: right">
					<tr>
						<td colspan="2">							
							<?php echo $this->Form->hidden('id', array('value' => $id)); ?>
							<?php echo $this->Form->hidden('status', array('value' => 'active')); ?>
							<?php echo $this->Form->end(__('Submit')); ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>		
	</div>
</div>

<?php echo $this->Html->css('rateit.css', null, array('block' => 'css')); ?>
<?php echo $this->Html->script('jquery.rateit.min.js'); ?>
<?php echo $this->Js->writeBuffer(); ?>