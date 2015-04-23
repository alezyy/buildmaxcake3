<div id="content_inner">
<div class="large">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('My Account'); ?></h1>
		</div>
	</div>

	<div class="location_view">

		<table class="table table-condensed" id="table_my_account">
			<tr>				
				<th class="fullname" colspan="2">
					<?php echo $this->Session->read('Auth.Profile.name') ?>
				</th>
			</tr>
			<tr>
				<?php echo $this->Session->read('Auth.User.email') ?>
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
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('name', __('Restaurant')); ?></th>
							<th><?php echo __("Items"); ?></th>
							<th ><?php echo $this->Paginator->sort('coupon_discount', __("Discount")) ?></th>
							<th ><?php echo $this->Paginator->sort('total', __("Total")) ?></th>
							<th><?php echo $this->Paginator->sort('date', __("Date")) ?></th>
							<th><?php echo $this->Paginator->sort( 'status' , __("Status")) ?></th>
                            <th title="<?php echo __('Review your order'); ?>"><?php echo __('Review'); ?></th>
						</tr>

						<?php foreach ($orders as $order) { ?>
							<?php
							$class = '';
							switch (strtolower($order['Order']['overall_status'])) {

								case 'accepted':
								case 'completed':
								case 'complete':
								case 'waiting_user':
                                    $order['Order']['overall_status'] = __('Completed');
									$class = 'success';
								break;

                                case 'waiting_resto':
								case 'rejected':
								case 'canceled':
                                    $order['Order']['overall_status'] = __('Rejected');                                    
									$class = 'error';
								break;                                                           
                                    

								case 'processing':
                                    $order['Order']['overall_status'] = __('Processing');
									$class = 'info';
								break;
							}
							?>
							<tr class='<?php echo $class; ?>'>
								<td><?php echo $order['Order']['id']      ?></td>
								<td><?php echo $order['Location']['name'] ?></td>

								<!-- Output all the items of taht order-->    
								<td class="items">
			
										<?php
										foreach ($order['OrderDetail'] as $detail) {


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
                                    <?php if(empty($order['Order']['coupon_discount']) || $order['Order']['coupon_discount'] == 0){ ?>
                                    -
                                    <?php } else { ?>
									<?php 
									echo $this->Number->currency(
										$order['Order']['coupon_discount'], 
										$langSuffix .'_'. Configure::read('I18N.COUNTRY_CODE_2'));
									?>
                                    <?php } ?>
								</td>
                                
								<td>
									<?php 
									echo $this->Number->currency(
										$order['Order']['total'], 
										$langSuffix .'_'. Configure::read('I18N.COUNTRY_CODE_2'));
									?>
								</td>
								<td>
									<?php
									echo $this->Date->formatDate($order['Order']['created']);
									?>
								</td>
								<td>
									<?php
									echo $this->Bootstrap->badge(__($order['Order']['overall_status']), $class);
									?>
								</td>
                                <td>
                                    <?php if(!empty($order['Rating']['id'])): ?>
                                        <?php echo $this->Html->link(__('Review'), 
                                            array(
                                                'controller' => 'ratings', 
                                                'action' => 'user_add', 
                                                $order['Rating']['id'],
                                                $this->Session->read('Auth.User.id'),
                                                $order['Order']['id'],
                                                )) ?>
                                    <?php else: ?>                                    
                                        <?php echo __('Not available');?>        
                                    <?php endif; ?>
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
                <div style="text-align: right">
                <?php echo __('Customer Service: '); ?><a href="tel:514 989 1233">514 989 1233</a>  
                </div>
		</div>
        
	</div>
</div>
<!--end content-->