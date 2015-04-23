<?php

// Data for javascript
echo $this->form->hidden('locationId', array('id' => 'locationId', 'value' => $location['Location']['id']));

?>

<div class="col-vs-12 no-padding">
	<div class="col-xs-12 col-md-9 no-padding">					
		<div class="col-xs-12 page-header results">	
			<div class="col-xs-12 col-md-9">	
				<h1 class="">
					<?php echo $location['Location']['name']; ?>
				</h1>				
				
				<h4 class="">
					<?php echo $cuisineTypeH2; ?>
				</h4>
				<?php if (!$isPdfLocation && $isDelivering): ?>
					<p class="badge success"><?php echo __('This location is currently open'); ?></p>					
				<?php else: ?>
					<p class="badge warning"><?php echo __('This location is currently closed'); ?></p>	
				<?php endif; ?>	
				<?php if ($location['Location']['rating'] > 0): ?> 
			        <form><input id="input-5a" class="rating" data-disabled="true" disabled="true" value="<?php echo $location['Location']['rating'] ?>"></form>
			    <?php endif ?>
			</div>
			<div class="col-md-3">
				<?php
				$image = $this->Image->out($location['Location']['logo'], '514x514', false, false, true,
					array(
                        "alt" => $location['Location']['name'], 
                        "title" => $location['Location']['name'], 
                        'class' => 'img-responsive restaurant_logo', 
                        'height' => 200,
                        'width' => 200
                    )
		        );
				if ($image) {
					echo $image; // if 514x514 image output this one
				} else {
					echo $this->Html->image('http://eat24hours.com/files/cuisines/v4/pizza.jpg',
		                //$this->Html->image('$location['Location']['logo']',
		                    array(
		                        "alt" => $location['Location']['name'], 
		                        "title" => $location['Location']['name'], 
		                        'class' => 'img-responsive', 
		                        'height' => 120,
		                        'width' => 120
		                    )
		                ); // output smaller image or nothing
				}
				?>
			</div>
		</div>

		<div class="container-white col-xs-12">
			<ul class="list-group">
				<?php if ($deliveryCharge === false) : ?>   
					<li class="list-group-item col-xs-12 col-md-6">                
						<i class="icon-exclamation-sign"></i>
						<?php echo __('Delivery unavailable for the current postal code.<br/>Please choose a different restaurant location.') ?>	
					</li>
				<?php else: ?>
					<li class="list-group-item col-xs-12 col-md-6">
						<strong><i class="fa fa-usd"></i> <?php echo __('Delivery Charge: '); ?></strong>
						<?php
						if (is_numeric($deliveryCharge)) {
							echo $this->Number->currency($deliveryCharge, $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
						} else {
							echo $deliveryCharge;
						}
						?>
					</li>					
					<?php if (!empty($minOrder)): ?>
						<li class="list-group-item col-xs-12 col-md-6">
							<strong><?php echo __('Delivery Minimum: '); ?></strong>
							<?php
							if (is_numeric($minOrder)) {
								echo $this->Number->currency($minOrder, $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
							} else {
								echo $minOrder;
							}
							?>
						</li>					
					<?php endif; ?>
					<li class="list-group-item col-xs-12 col-md-6">
						<strong><i class="fa fa-clock-o"></i> <?php echo __('Delivery Average Time: '); ?></strong>
						<?php echo $location['Location']['delivery_average_time']; ?>
						<?php echo __('minutes'); ?>
					</li>	
					<?php if (!$isPdfLocation): ?>
						<li class="list-group-item col-xs-12 col-md-6">
							<strong><i class="fa fa-calendar-o"></i> <?php echo __('Today\'s schedule: '); ?></strong>
							<?php
							$scheduleString = $this->Schedule->scheduleNiceArray($schedule);
							echo $scheduleString['Schedule']['string'];
							?>
						</li>					
					<?php endif; ?>
				<?php endif; ?>
			</ul>

			<div class="clearfix"></div>

			<?php if (!$isPdfLocation) : ?>	
				<ul class="nav nav-tabs tabs-up space" id="location">
			

				
					<li class="active"><?php
					// Load the  menu from ajax
					echo $this->Html->link(
						__('Menu'),
						'#',
						array(
							'class' => 'media_node active span',
							'rel' => 'tooltip',
							'id' => 'menus_tab',
							'data-target' => "#menus",
							'data-toggle' => "tab"
						)
					); ?>
					</li>

					<li>
						<?php
						// in the controller, the restaurant url can be catch from $this->request('location')
						echo $this->Html->link(
							__('Info'), array(
							'controller' => 'locations',
							'action' => 'info',
							'info' => $location['Location']['url']), array(
							'class' => 'media_node span',
							'rel' => 'tooltip',
							'id' => 'infos_tab',
							'data-target' => "#infos",
							'data-toggle' => "tabajax"
						)); ?>
					</li>

					<li>
						<?php
						// in the controller, the restaurant url can be catch from $this->request('location')
						echo $this->Html->link(
							__('Reviews'), array(
							'controller' => 'ratings',
							'action' => 'view',
							$location['Location']['url']), array(
							'class' => 'media_node span',
							'rel' => 'tooltip',
							'id' => 'ratings_tab',
							'data-target' => "#ratings",
							'data-toggle' => "tabajax"
						)); ?>
					</li>
				</ul>
			<?php endif ?>
			

			<div class="tab-content">
				<div class="tab-pane active" id="menus">
					<!-- menu tab content. Populated with AJAX response view when the tab is clicked -->
					<?php if (!empty($items) && !$isPdfLocation) : ?>
						<div class="panel-group space" id="accordion">
							<div class="">
								<?php if ($location['Location']['tip']): // if tip is enabled ?>
									<!-- Tip Panel -->
									<div class="panel">
										<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#tip">
											<h4 class="panel-title">
										    	<a class="accordion-toggle">
										      	<strong><?php echo __('Tip the driver'); ?></strong>
										    	</a>
										    	<i class="fa fa-minus pull-right indicator"></i>
										  	</h4>
										</div>
										<div id="tip" class="panel-collapse collapse in">
										  	<div class="panel-body">
										    	<p>
											    	<i>
														<?php echo __('Include the drivers tip directly in your order'); ?>
													</i>
												</p>
												<table id="" class="table table-hover" >					
												<?php foreach ($tipOptions as $tipOption) : ?>
													<tr class="">
														<td class=''><?php echo __('Tip'); ?></td>
														<td class='text-right'>
															<?php
															echo $this->Html->link(
																$this->Number->currency($tipOption['TipOption']['amount'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')).' <i class="fa fa-plus-circle"></i>', 
																array(
																	'controller' => 'tipOptions',
																	'action' => 'add_to_order',
																	$tipOption['TipOption']['amount'],
																	$location['Location']['id']
																), 
																array(
																	'class' => 'ajax_cart', 
																	'rel' => 'nofollow',
																	'escape' => false,
																	'tip_amount' => number_format((float) $tipOption['TipOption']['amount'], 2, '.', '')
																)
															);
															?>
														</td>
													</tr>
												<?php endforeach; ?>
												</table>
										  	</div>
										</div>
									</div>	
								<?php endif ?>
									
								<?php foreach ($categories as $category): ?>
									<?php $catImage = $this->Image->out($category['MenuCategory']['image'], '700x700', true, true, false); ?>
									<div class="panel">
									<?php if (empty($catImage)) : ?>
										
											<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#<?php echo $category['MenuCategory']['id'] ?>">
												<h4 class="panel-title">
											    	<a class="accordion-toggle">
											      		<strong><?php echo $category['MenuCategory']['name']; ?></strong>
											    	</a>
											    	<i class="fa fa-plus pull-right indicator"></i>
											  	</h4>
											</div>
										
										<?php else: ?>	
										
											<div class="collapsed category-image" data-toggle="collapse" data-parent="#accordion" data-target="#<?php echo $category['MenuCategory']['id'] ?>" style="background-image:url(<?php echo $this->Image->out($category['MenuCategory']['image'], '700x700', false, true, false);?>)">				
												<h4 class="panel-title panel-heading ">
											    	<a class="accordion-toggle">
											      		<strong><?php echo $category['MenuCategory']['name']; ?></strong>
											    	</a>
											    	<i class="fa fa-plus pull-right indicator"></i>
											  	</h4>
											</div>
										
									<?php endif; ?>
									<div id="<?php echo $category['MenuCategory']['id'] ?>" class="panel-collapse collapse">
									  	<div class="panel-body">
										  	<p>
										  		<i>
													<?php echo $category['MenuCategory']['description']; ?>
												</i>
											</p>
											<table id="" class="table table-hover" >					
											<?php foreach ($items as $item) : ?>
												<?php if ($item['MenuItem']['menu_category_id'] === $category['MenuCategory']['id']):
													if (!empty($item['MenuItem']['no_price_text'])) {
														$priceString = $item['MenuItem']['no_price_text'];
													} else {
														$priceString = $this->Number->currency($item['MenuItem']['price'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
													}
													?>
													<tr class="">
														<td class="caption">
															<?php if (!empty($item['MenuItem']['image'])) :
																echo $this->Html->link( 
													                $this->Image->out($category['MenuCategory']['image'], '64x64'),
													                $this->Image->out($category['MenuCategory']['image'], '700x700', false, true), //menu item image URL
													                array(
													                    'escape' => false,
													                    'class' => 'preview'
													                )
													            ); 
															endif ?>
														</td>
														<td class=''><span><?php echo $this->Html->link(
															$item['MenuItem']['name'], array(
															'controller' => 'menuItems',
															'action' => 'options_modal',
															$item['MenuItem']['id']), array(
															'class' => 'item-ajax please_wait_clicked',
															'escape' => false,
															'target' => '_self')); ?></span><br/>
															<i>
															<i class='category-description'>
																<?php echo $item['MenuItem']['description'] ?>
															</i>
														</td>
														<td class='text-right no-wrap'>
														<?php echo $this->Html->link(
																$priceString.' <i class="fa fa-plus-circle"></i>', 
																array(
																'controller' => 'menuItems',
																'action' => 'options_modal',
																$item['MenuItem']['id']), array(
																'class' => 'item-ajax please_wait_clicked',
																'escape' => false,
																'data-toggle' => 'modal',
																'data-target' => '#options_modal'
															)
														); ?>
														</td>
													</tr>
												<?php endif ?>	
											<?php endforeach; ?>
											</table>
									  	</div>
									</div>
								</div>
								<?php endforeach ?>
								
								
							</div>
						</div>
					<?php endif ?>

				</div>

				<div class="tab-pane" id="infos">
					<!-- info tab content. Populated with AJAX when the tab is clicked -->
				</div>
				<div class="tab-pane  urlbox span8" id="ratings">
					<!-- reviews tab content. Populated with AJAX when the tab is clicked -->
				</div>
			</div>




		</div>
	</div>

	<div class="col-xs-12 col-md-3 pull-right sidebar-parent sidebar-right">
		<div class="affix-top sidebar col-xs-12" id="cart">
			<?php echo $this->element('cart'); ?>
		</div>
	</div>
</div>
					
		










		</div>
	</div>
</div>




<?php // echo $this->element('postal_code_prompt_box'); ?>














<!-- Modal filled with Ajax. This modal has the form to add a note to an item order, or to increase the quantity of items added to cart-->
<div class="modal fade no-padding" id="options_modal" tabindex="-1" role="dialog" aria-labelledby="optionsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-body col-xs-12">
		</div>	
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->