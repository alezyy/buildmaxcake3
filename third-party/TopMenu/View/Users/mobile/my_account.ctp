
<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('My Account'); ?></h1.
		</div>
	</div>

	<div class="location_view">

		<table class="table table-condensed" id="table_my_account">
			<tr>
				<td rowspan="6">        
					<?php echo $this->Image->out($user['Profile']['image'], '64x64'); ?>
				</td>
				<th class="fullname" colspan="2">
					<?php echo $user['Profile']['name'] ?>
				</th>
			</tr>
			<tr>
				<td><?php echo $user['User']['email'] ?></td>
			</tr>
			<tr>
				<td><?php echo preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $user['Profile']['phone']) ?></td>
			</tr>   
		</table>
		</td>
		</tr>
		<tfoot>
			<tr>
				<!-- Edit Links-->
				<td colspan="2">                            
					<?php
					echo $this->Html->link(__("Edit Profile"), array(
						'controller' => 'profiles',
						'action' => 'edit'), array('class' => 'edit'));
					?>
					&nbsp;|&nbsp;

					<?php
					echo $this->Html->link(__("View Delivery Addresses"), array(
						'controller' => 'delivery_addresses', 'action' => 'index'), array('class' => 'edit'));
					?>   
					&nbsp;|&nbsp;

					<?php
					echo $this->Html->link(__("Add delivery address"), array(
						'controller' => 'delivery_addresses',
						'action' => 'user_add'), array('class' => 'edit'));
					?>   
				</td>
			</tr>
		</tfoot>
		</table>



		<!-- Delete payment information (if existes) -->
		<?php
//TODO find where is store the users payment information and modify this section
		if (!empty($user['digits'])) {
			echo $this->Html->link(__("Delete Payment informations"), array(
				'controller' => 'TODO',
				'action' => 'TODO'), array('class' => 'delete'));
		}
		?>



		<!-- Orders history -->
		<?php if (!empty($orders)) { ?>        
			<div id="order_history">
				<h2><?php echo __("Order History") ?></h1>            



					<table class="table table-striped table-bordered table-condensed table-hover">
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo __("Items"); ?></th>
							<th ><?php echo __("Total") ?></th>
							<th><?php echo __("Date") ?></th>
						</tr>

						<?php foreach ($orders as $order) { ?>

							<tr>
				<!--                        <td><?php // echo $order['Order']['id']      ?></td>-->
								<td><?php echo $order['Location']['name'] ?></td>

								<!-- Output all the items of taht order-->    
								<td class="items">
			
										<?php
										$orderPrice = 0;
										foreach ($order['OrderDetail'] as $detail) {

											// sum up the totals price of the order
											$orderPrice += $detail['quantity'] * $detail['price'];
											?>											
												<div style="float: left; padding: .2em">
													<?php echo $detail['name'] ?>
												</div>
												<div style="float: right; padding: .2em">
													&nbsp;X&nbsp;<?php echo $detail['quantity'] ?>
												</div>
											<br/>
										<?php } ?>
									
								</td>

								<td>
									<?php 
									echo $this->Number->currency(
										$orderPrice, 
										$langSuffix .'_'. Configure::read('I18N.COUNTRY_CODE_2'));
									?>
								</td>
								<td>
									<?php
									//todo redo i18n for the date
									echo $this->Date->formatDate($order['Order']['created']);
									?>
								</td>
							</tr>
						<?php } ?>
					</table>

					<!-- Pagination menu -->  

					<p>
						<?php
						echo $this->Paginator->counter(array(
							'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
						));
						?>	
					</p>
					<div class="pagination">
						<ul>
							<?php
							echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => ''));
							echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
							?>
						</ul>
					</div>


				<?php } ?>
				</table>
		</div>
	</div>
</div>
<!--end content-->