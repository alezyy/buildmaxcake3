<?php
// META TAGS //TODO put in controller
$cuisineType = '';
$cuisineTypeH2 = '';
foreach ($location['Cuisine'] as $value) {
	$cuisineType = $cuisineType . ", " . $value['name'];
	$cuisineTypeH2 = $value['name'] . ', ' . $cuisineTypeH2;
}
$cuisineTypeH2 = substr($cuisineTypeH2, 0, strlen($cuisineTypeH2) - 2);

$commonKeywords = __('Delivery, Topmenu, Restaurants, ') . $location['Location']['sector_slug'];
$keywords = htmlentities($commonKeywords . $cuisineType,  ENT_QUOTES);
$metaDescriptionString = htmlentities($location['Location']['description'], ENT_QUOTES);
$metaCityString = htmlentities($location['Location']['city'], ENT_QUOTES);
$metaStateString = htmlentities($location['Location']['province'],  ENT_QUOTES);

$this->set('meta_keywords', "<meta name='keywords' content='$keywords' />\n");
if (!empty($metaDescriptionString)) {
	$this->set('meta_description', "<meta name='description' content='$metaDescriptionString' />\n");
}
$this->set('meta_zipcode', "<meta name='zipcode' content='$metaDeliveryAreas' />\n");
$this->set('meta_city', "<meta name='city' content='$metaCityString' />\n");
$this->set('meta_state', "<meta name='state' content='$metaStateString' />\n");

// Data for javascript
echo $this->form->hidden('locationId', array('id' => 'locationId', 'value' => $location['Location']['id']));

// Extra css
echo $this->Html->css('rateit.css', null, array('block' => 'css'));
?>

<div id="content_inner">

	<div class="other_left_cntnr" itemscope="" itemtype="http://schema.org/Restaurant">

		
		<!-- Header -->
		<div class="gray_head_box">			
			<div class="gray_head_heading" style="padding-top: 5px; padding: 10px 10px 0px 10px;">		
				
				<!-- Page title -->
				<div style="float: left; max-width: 550px">					
					<h1 style="line-height: 0.8em; margin: 0px; padding: 0px;">
						<?php echo $location['Location']['name']; ?>
					</h1>				
					
					<h2 style="font-size: 12px; margin: 3px 0px 0px 0px; line-height: 14px;">
						<?php echo $cuisineTypeH2; ?>
					</h2>
				</div>
				
				<!-- Rating stars -->
				<div style="float: right;">
					<span class="rateit" data-rateit-value="<?php echo $location['Location']['rating'] ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></span>
				</div>								
			</div>
		</div> 

		<!-- Content --> 
		<div class="location_view">
			<div id="location_header-image">
				<?php
				$image = $this->Image->out($location['Location']['logo'], '514x514', TRUE, FALSE, FALSE, array('width' => '100%',));
				if ($image) {
					echo $image; // if 514x514 image output this one
				} else {
					echo $this->Image->out($location['Location']['logo'], '120x120', true, false, FALSE, array('width' => '100%',)); // output smaller image or nothing
				}
				?>
			</div>
			<div id="location_header-text">

				<?php if (!$isPdfLocation): ?>
					<?php if ($isDelivering): ?>
						<p class="strong"><?php echo __('This location is currently open'); ?></p>					
					<?php else: ?>
						<p class="strong"><?php echo __('This location is currently close'); ?></p>	
					<?php endif; ?>	
				<?php endif; ?>	

				<?php if ($deliveryCharge === false) : ?>   
					<p class="mB10 strong">                
						<i class="icon-exclamation-sign"></i>
						<?php echo __('Delivery unavailable for the current postal code.<br/>Please choose a different restaurant location.') ?>               						
					</p>
				<?php else: ?>
					<p>
						<span class="strong"><?php echo __('Delivery Charge: '); ?></span>
						<?php
						if (is_numeric($deliveryCharge)) {
							echo $this->Number->currency($deliveryCharge, $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
						} else {
							echo $deliveryCharge;
						}
						?>
					</p>					
					<?php if (!empty($minOrder)): ?>
						<p>
							<span class="strong"><?php echo __('Delivery Minimum: '); ?></span>
							<?php
							if (is_numeric($minOrder)) {
								echo $this->Number->currency($minOrder, $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
							} else {
								echo $minOrder;
							}
							?>
						</p>					
					<?php endif; ?>
					<p>
						<span class="strong"><?php echo __('Delivery Average Time: '); ?></span>
						<?php echo $location['Location']['delivery_average_time']; ?>
						<?php echo __('minutes'); ?>
					</p>	
					<?php if (!$isPdfLocation): ?>
						<p>
							<span class="strong"><?php echo __('Today\'s schedule: '); ?></span>
							<?php
							$scheduleSting = $this->Schedule->scheduleNiceArray($schedule);
							echo $scheduleSting['Schedule']['string'];
							?>
						</p>					
					<?php endif; ?>
				<?php endif; ?>
				<?php if (!empty($location['Location']['description'])): ?>
					<span class="strong">
						<?php echo __('Description: '); ?>
					</span>
					<br/>
					<?php echo $location['Location']['description']; ?>
				<?php endif; ?>



			</div>

			<br/>
			<br/>
			<br/>

			<div class="clear"></div>


			<div>

				<?php
				// Load the  menu from ajax
				echo $this->Html->link(
					__('Menu'), array(
					'controller' => 'menus',
					'action' => 'location_menu',
					'menu' => $location['Location']['url']), array(
					'class' => 'js-ajax active',
					'hidden' => 'hidden',
					'id' => 'tab-menu',
					'role' => 'button'));
				?>

				<?php if (!$isPdfLocation) : ?>
					<ul class="nav nav-tabs">

                        <li class="active">
                            <?php
                            // in the controller, the restaurant url can be catch from $this->request('location')
                            echo $this->Html->link(
                                __('Menu'), array(
                                'controller' => 'locations',
                                'action'     => 'view',
                                'location'   => $location['Location']['url'],
                                'sector'     => $location['Location']['sector_slug']
                                ), array(
                                'class' => 'js-ajax active',
                                'id'    => 'tab-menu',
                                'role'  => 'button'));
                            ?>
                            </li>

						<li>
							<?php
							// in the controller, the restaurant url can be catch from $this->request('location')
							echo $this->Html->link(
								__('Reviews'), array(
								'controller' => 'ratings',
								'action' => 'view',
								$location['Location']['url']), array(
								'class' => 'tab-ajax',
								'id' => 'tab-reviews',
								'role' => 'button'));
							?>
						</li>

						<li>
							<?php
							// in the controller, the restaurant url can be catch from $this->request('location')
							echo $this->Html->link(
								__('Info'), array(
								'controller' => 'locations',
								'action' => 'info',
								'info' => $location['Location']['url']), array(
								'class' => 'tab-ajax',
								'id' => 'tab-info',
								'role' => 'button'));
							?>
						</li>

						<li>

							<a action="show" href="javascript:void(0)" class="tab-ajax" id="toogleCollapsable" role="button"><?php echo __('Open all categories'); ?></a>							
							<input type="hidden" value="<?php echo __('Open all categories'); ?>" id="showAll"/>		<!-- //todo user jquery i18n instead when it will be implemented -->
							<input type="hidden" value="<?php echo __('Close all categories'); ?>" id="closeAll"/>		<!-- //todo user jquery i18n instead -->
						</li>

					</ul>
					<?php endif; ?>

				<!-- MENU -->
				<div id="contentMenu">
					<div id="addItemResponse"></div>
					<?php
					$i = 0; // $counter for collaspsing div    
					$isUnCollapsed = 'in'; // flag to toggle collapse/not collapse by default. If set to = ' in' then div in open.
					?>

					<?php
					// iterate and display menu's groups    
					$even = 0;  // even or odd number
					if (!empty($items) && !$isPdfLocation) {
						?>

						<!-- Tip the driver -->

                            <?php // Remove Tips for one restaraurant //TODO add a field in the locations table for "tip is enable" to replace this crap?>
                            <?php if (
                                $location['Location']['id'] !== '528103ac-ddb8-43d3-a714-6a881ec880c8'
                                && $location['Location']['id'] !== '52810422-1690-4e06-8946-6a881ec880c8'
                                ): ?>
                        
						<div class="accordion-group" id="top-tip">
							
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#tipdiv">
								<div class="accordion-heading category-no-image">					
									<div class="caption caption-no-image">	
										<p>
											<?php echo __('Tip the driver'); ?>
											<?php echo $this->Html->image('1388712944_basic1-149_mouse_hand_click.png', array('class' => 'icon_collapsible')); ?>						
										</p>
									</div>						
								</div>
							</a>
							
							<div id="tipdiv" class="accordion-body collapse">
								<div class="category-description">
									<p>
										<?php echo __('Include the drivers tip directly in your order'); ?>
									</p>
								</div>
								
								<ul id="tip_ul" class="menu" >					
								<?php foreach ($tipOptions as $tipOption) { ?>
									<li class="odd alternate">
										<span class='writeLeft'><?php echo __('Tip'); ?></span>
										<span class='writeRight nowrap'>
											<?php
											echo $this->Html->link(
												$this->Number->currency($tipOption['TipOption']['amount'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')), array(
												'controller' => 'tipOptions',
												'action' => 'add_to_order',
												$tipOption['TipOption']['amount'],
												$location['Location']['id']), array('class' => 'odd alternate add_tip', 'rel' => 'nofollow', 'tip_amount' => number_format((float) $tipOption['TipOption']['amount'], 2, '.', '')));
											?>
										</span>
									</li>
								<?php } ?>
								</ul>
							</div>
						</div>
                        <?php endif; ?>

						<!-- Menu Item Grouped by Menu-groups -->
						<?php
						foreach ($categories as $category) {
							$i++;
						?>
						<div class="accordion-group" id="top-<?php echo $category['MenuCategory']['id'] ?>">
							<?php $catImage = $this->Image->out($category['MenuCategory']['image'], '700x700', true, true, false); ?>
							<?php if (empty($catImage)) { ?>
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $category['MenuCategory']['id'] ?>">
								<div class="accordion-heading category-no-image">					
									<div class="caption caption-no-image">	
										<p>
											<?php echo $category['MenuCategory']['name']; ?>
											<?php echo $this->Html->image('1388712944_basic1-149_mouse_hand_click.png', array('class' => 'icon_collapsible')); ?>						
										</p>
									</div>						
								</div>
							</a>
							<?php } else { ?>				
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $category['MenuCategory']['id'] ?>">
								<div class="accordion-heading category-image" style="background-image: url(<?php echo $catImage; ?>)">					
									<div class="caption">
										<p>
											<?php echo $category['MenuCategory']['name']; ?>
											<?php echo $this->Html->image('1388712944_basic1-149_mouse_hand_click.png', array('class' => 'icon_collapsible')); ?>						
										</p>
									</div>

								</div>
							</a>						
							<?php } ?>	
							<div id="<?php echo $category['MenuCategory']['id'] ?>" class="accordion-body collapse">
								<div class="category-description">
									<p>
										<?php echo $category['MenuCategory']['description']; ?>
									</p>
								</div>

								<?php

															$even = 2;
															?>
										<ul id="menu_ul" class="menu">
															<?php
															foreach ($items as $item) { // iterate all the items withing this group						
																if ($item['MenuItem']['menu_category_id'] === $category['MenuCategory']['id']) {

																	if (!empty($item['MenuItem']['no_price_text'])) {
																		$priceString = $item['MenuItem']['no_price_text'];
																	} else {
																		$priceString = $this->Number->currency($item['MenuItem']['price'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
																	}
																	?>

													<li class="odd alternate">								
														<div class="hasAuthentic">
															<?php
															// Has authentiq image
															if (!empty($item['MenuItem']['image'])) {
																echo $this->Html->link(
																	// Image
																	$this->Html->image(
																		'BOUTONS/has_image.png', array(
																		'class' => 'add_basket',
																		'title' => __('Show items genuine photo'))),
																	// link options
																	array(
																	'controller' => 'menuItems',
																	'action' => 'options_modal',
																	$item['MenuItem']['id']), array(
																	'class' => 'image-ajax please_wait_clicked',
																	'escape' => false,
																	'target' => '_self'));
															} else {
																?>
																<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAABCAYAAABUvRdkAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QwCEzATSBXq3wAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAD0lEQVQI12P8//8/w2ABAKCIAv/BIiiOAAAAAElFTkSuQmCC" />
														<?php
													}
													?>
														</div>
														<span class='writeLeft'>
															<?php
															echo $this->Html->link(
																$item['MenuItem']['name'], array(
																'controller' => 'menuItems',
																'action' => 'options_modal',
																$item['MenuItem']['id']), array(
																'class' => 'item-ajax please_wait_clicked',
																'escape' => false,
																'target' => '_self'));
															?>
															<p class='category-description'>
															<?php echo $item['MenuItem']['description'] ?>
															</p>
														</span>
														<span class='writeRight nowrap'>

															<?php
															echo $this->Html->link($priceString, array(
																'controller' => 'menuItems',
																'action' => 'options_modal',
																$item['MenuItem']['id']), array(
																'class' => 'item-ajax please_wait_clicked',
																'escape' => false,
																'target' => '_self'));
															?>
														</span>
													</li>
															<?php
														}
													}
												?>
									</ul>
								</div>
							</div>
										<?php } ?>


                    <?php } else { ?>
						<!-- No menu where found -->
                        <?php 
                        
                        // NO ONLINE ORDERING 
                        
                        // a few restaurant have two versions of there page (one PDF one online) and are indexed so we need to keep does pdf version. 
                        // Here we are adding a link to the online version to those restaurans apges
                        switch($location['Location']['id']){
                            case '528103af-350c-45a7-a0fd-6a881ec880c8': ?>
                        
                        <a href="http://www.topmenu.com/en/restaurant/rosemont-west/o-fuzion" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '528103d3-b9ac-4cc7-8abc-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/hochelaga/rice-box" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                       <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '5281041e-4e90-4daa-ab1b-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/aiko-sushi" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                       <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810424-440c-4ee5-8140-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/centre-sud/tabla-village" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '528104ad-a278-49bd-b647-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/snowdon-upper-westmount-cote-des-neiges/pizza-mima" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810523-9530-4c3f-80df-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/salonica" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810558-cda4-43eb-a059-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/ambala" id="downloadPdfMenu" class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php 
                        
                        // back to normal locations
                        default:

                            if (!empty($location['Location']['pdf_menu'])) : 
                                echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu','class' => "btn btn-success"), __('Open the PDF Menu')); ?>						
                                <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                            <?php 
                            else: 
                                echo __('No menus were found');
                            endif; 
                        break;                         
                        }                          
                    } 
                    echo $this->Html->script('please_wait'); ?>                                                

					<div id="option">

					</div>
				</div>


				<!-- Everything inside this the next div will be replace by ajax call -->
				<div id="contentAjax">
				</div>

			</div>


		</div>
    </div>
	
	
	<!-- Order summary right bar -->
	<div id="orderSummary">


		<div class="search_wrapper">
			&nbsp;
			<div class="other_pages_left">

				<?php if ($is_tablet): // Remove affix behavior ?>
				<div id="search" data-offset-top="260" data-offset-bottom="250" style="margin-left: 44px">
				<?php else: ?>
				<div id="search" data-spy="affix" data-offset-top="260" data-offset-bottom="250" style="margin-left: 44px">
				<?php endif; ?>
				<div class="small_header_cntnr">
					<h1 class="small_header_title"><strong><?php echo __('Your Order'); ?></strong></h1>
				</div>

				<div class="other_pages_right_tab" style="float: left;">
                    
                    <?php if (!$isPdfLocation): ?>
				<?php
				echo $this->Form->create('Order', array(
					'url' => array('controller' => 'orders', 'action' => 'checkout')));
				?>
					<table class="cart_table_content" id="order_content">
						<tbody>

							<tr>
								<th class="arial10 left"><?php echo __('Items'); ?></th>		
								<th class="arial10 center" ><?php echo __('QTY'); ?></th>																
								<th class="arial10 right"><?php echo __('Price'); ?></th>
								<th></th>
							</tr>
							<tr>
								<td colspan="4" class="cart_dotted_line">&nbsp;</td>
							</tr>

							<?php if (!$this->Session->check('Order.OrderDetail')) { ?>
							<tr>
								<td colspan="4">
									<p class="category-description center">
										<br/>
										<?php echo __('Select items from the menu to start ordering'); ?>
									</p>
								</td>
							</tr>
							<?php } else { ?>
								<?php foreach ($this->Session->read('Order.OrderDetail') as $k => $detail) { ?>
							<tr>
								<td>
								<?php echo $detail['name']; ?>
								</td>	
								<td class="center">
								<?php echo $detail['quantity']; ?>
								</td>							
								<td class="right no_wrap">
								<?php echo $this->Number->currency($detail['subtotal'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
								</td>
								<td class="right">
								<?php
								echo $this->Html->link(
									'✖', array(
									'controller' => 'menuItems',
									'action' => 'remove_item',
									$k), array(
									'class' => 'summary-ajax',
									'role' => 'button',
									'rel' => 'nofollow'));
								?>
								</td>
							</tr>
							<?php } ?>
						<?php } ?>
							<tr>
								<td colspan="4" class="cart_dotted_line">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="right"><?php echo __('Delivery'); ?></td>
								<td class="right no_wrap">
							<?php
							echo $this->Number->currency(
								$this->Session->read('Order.Order.delivery_charge'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
							?>
								</td>
								<td></td>
							</tr>						
							<tr>					
								<td colspan="2" class="right"><?php echo __('Subtotal'); ?></td>
								<td class="right no_wrap">
									<?php
									echo $this->Number->currency(
										$this->Session->read('Order.Order.subtotal'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
									?>
								</td>
								<td></td>
							</tr>		
							<tr>
								<td colspan="2" class="right"><?php echo __('Tip'); ?></td>
								<td id="tip_td" class="right no_wrap">
									<?php
									echo $this->Number->currency(
										$this->Session->read('Order.Order.tip'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
									?>
								</td>
								<td class="right">
									<?php
									echo $this->Html->link('✖', '/tip_options/remove_tip', array(
									'class' => 'summary-ajax x_delete',
									'role' => 'button',
									'rel' => 'nofollow'));
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="right strong">
									<?php echo __('Total'); ?>
								</td>
								<td id="total_td" class="strong right">
									<?php
									echo $this->Number->currency(
										$this->Session->read('Order.Order.total'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
									?>
								</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="4" class="cart_dotted_line">&nbsp;</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4">
									<div id="flashMessage"></a>
										<?php echo $this->Session->flash('sidebar'); ?>
									</div>
								</td>
							</tr>
						</tfoot>
					</table>	
					
				<?php if ($this->Session->check('Order')): ?>
					<div class="btn-group btn-group-vertical pull-right" style="width: 100%; float: left">
						<?php
						echo $this->Html->link(
							__('Clear order'), "/menu_items/empty_cart/{$location['Location']['id']}", array(
							'role' => 'button',
							'class' => 'btn',
							'rel' => 'nofollow'), __('Are you sure you want to delete the order?'));

						$delType = $this->Session->read('Order.Order.type');
						echo $this->Order->orderTypeSwitcher($delType, $location['Location']['url'], $location['Location']['id']);
						echo $this->Form->submit(
							__('Proceed to checkout'), array(
							'class' => 'btn btn-success',
							'style' => 'width: 100%;',
							'div' => false,
							$this->Session->read('enableCheckout') ? 'FALSE' : 'disabled'));
						?>
				<?php endif; ?>
						<?php
						echo $this->Form->hidden('user_id', array(
							'value' => $this->Session->read('Auth.User.id')));
						echo $this->Form->hidden('location_id', array(
							'value' => $location['Location']['id']));
						echo $this->Form->end();
						?>
						<div id="option"></div>
					</div>
					<div class="left_box-shadow">&nbsp;</div>
                    <?php else: ?>
                        <p class="strong" style="padding: 5px"><?php echo __('This restaurant does not offer online ordering'); ?></p>
                    <?php endif; ?>
					</div>
					
					</div>
				</div>

			</div>



		</div>

								<?php
								// Empty form use to to call action //TODO: this is ugly
								echo $this->Form->create(null, array(
									'url' => array(
										'controller' => 'locations',
										'action' => 'set_order_type',
										'type' => 'delivery',
										'locationUrl' => $location['Location']['url'],
										'locationId' => $location['Location']['id']),
									'type' => 'post',
									'id' => 'delivery'));
								echo $this->Form->end();
								echo $this->Form->create(null, array(
									'url' => array(
										'controller' => 'locations',
										'action' => 'set_order_type',
										'type' => 'pickup',
										'locationUrl' => $location['Location']['url'],
										'locationId' => $location['Location']['id']),
									'type' => 'post',
									'id' => 'pickup'));
								echo $this->Form->end();
								?>
		
<!-- // Prompt user for a postal code if none exist in the session -->
<?php echo $this->element('postal_code_prompt_box'); ?>
        
<?php if($location['Location']['online_ordering']): ?>
<script type="text/javascript">ga('set', 'contentGroup1', 'Online Restaurant Pages');</script>
<?php endif; ?>

<?php  // include other files
echo $this->Html->script('jquery-ui-1.10.3.spinner.min.js');    //TODO replace the spinner input box with number box
echo $this->Html->script('location_view');
echo $this->Html->script('location_view_desktop');
echo $this->Html->script('jquery.rateit.min.js');
echo $this->Js->writeBuffer(); 
								