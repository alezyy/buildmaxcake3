<?php 
$cuisineType = '';

// META TAGS //TODO put in controller
foreach ($location['Cuisine'] as $value) {
	$cuisineType = $cuisineType . ", " . $value['name'];
}

$commonKeywords = __('Delivery, Topmenu, Restaurants, ') . $location['Location']['sector_slug'];
$keywords = htmlentities($commonKeywords.$cuisineType, ENT_QUOTES);
$metaDescriptionString = htmlentities($location['Location']['description'], ENT_QUOTES);
$metaCityString = htmlentities($location['Location']['city'], ENT_QUOTES);
$metaStateString = htmlentities($location['Location']['province'], ENT_QUOTES);

$this->set('meta_keywords', "<meta name='keywords' content='$keywords' />\n");
if (!empty($metaDescriptionString)) {
	$this->set('meta_description', "<meta name='description' content='$metaDescriptionString' />\n");
}
$this->set('meta_zipcode', "<meta name='zipcode' content='$metaDeliveryAreas' />\n");
$this->set('meta_city', "<meta name='city' content='$metaCityString' />\n");
$this->set('meta_state', "<meta name='state' content='$metaStateString' />\n");
?>

<?php

// display the destination form? (hidden fields to pass data to js)
if ($this->Session->read('DeliveryDestination.asked') === TRUE) {
		echo "<span id='openModal' style='display: none'>dont open</span>"; // dont open 
	} else {
		echo "<span id='openModal' style='display: none'>open</span>";	// open
	}
?>

<!-- Show a prompt box asking the user it's postal code it's impossible to find way elsewhere -->
<?php echo $this->element('postal_code_prompt_box'); ?>

<div id="mobile-inner_content">

	<?php if ($this->Session->check('Order.Order.total')): ?>
		<?php if ($this->Session->read('Order.Order.total') > 0): ?>	
    
    
    <!-- DELIVERY --- -->     
    
			<div id="proceed_to_payment_bar">	
                <table id="greenHeaderInContent">
						<tr>
        
					<?php $minOrder = (empty($minOrder) ? NULL : $minOrder); ?>
					<?php if ((($this->Session->read('Order.Order.subtotal') - $this->Session->read('Order.Order.delivery_charge') >= $minOrder)) || !is_numeric($minOrder)) : ?>
						<?php if (!is_numeric($minOrder) || $this->Session->read('Order.Order.type') === 'pickup'): ?>
					
                            <!-- Unsure about the delivery destination -->
					
                            <!-- delivery image -->
                            <td>
                                <a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $langSuffix, '?' => array('type' => 'delivery'))) ?>">
                                    <?php echo $this->Html->image('delivery_green.png', array('width' => '30')); ?>
                                </a>
                            </td>
                            
                            <!-- delivery text -->
                            <td style="min-width: 50%;">
                                <a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $langSuffix, '?' => array('type' => 'delivery'))) ?>">
                                    <?php echo __('Delivery'); ?>: <?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                                </a>
                            </td>

						<?php else: ?>
					
                            <!-- Everything is correct -->
                    
                            <!-- delivery image -->
                            <td>
                                <a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $langSuffix, '?' => array('type' => 'delivery'))) ?>">
                                    <?php echo $this->Html->image('delivery_green.png', array('width' => '30')); ?>
                                </a>
                            </td>
                            
                            <!-- delivery text -->
                            <td style="min-width: 50%;">
								<a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'language' => $langSuffix, 'action' => 'checkout', '?' => array('type' => 'delivery'))) ?>">
									<?php echo __('Delivery'); ?>: <?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
								</a>	
                            </td>
					
						<?php endif; ?>
					<?php else: ?>
					
        					<!-- Order minimum amount not reach. Disallow user to continue but show him a message  -->
                    
                            <!-- delivery image -->
                            <td>
                                <a class="accordion-toggle" href="javascript:void(0)">
                                    <?php echo $this->Html->image('delivery_green_disable.png', array('width' => '30')); ?>
                                </a>
                            </td>
                            
                            <!-- delivery text -->
                            <td style="min-width: 50%;">
								<a class="accordion-toggle" href="javascript:void(0)">
									<span  class="disable">
										<?php echo __('Order Delivery: '); ?>
                                            <span class="nowrap">
                                                <?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                                            </span>
									</span>			
								</a>
                            </td>


					<?php endif; ?>
                    
                            </td>
                            <td>
                                <?php echo $this->Html->image('green_ribbon_border.png', array('style' => 'height: 50px;')); ?>
                            </td>
                            
                            <!-- Pickup image -->
                            <td class="right">
				
                                <a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $langSuffix, '?' => array('type' => 'pickup'))) ?>">

                                    <?php $pickupTotal = $this->Session->read('Order.Order.total') - $this->Session->read('Order.Order.delivery_charge'); ?>
                                    <?php echo __('Take-out'); ?>                                    
                                </a>	
                            </td>
                            
                            <!-- Pickup text -->
                            <td>
                                <a class="accordion-toggle" href="<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $langSuffix, '?' => array('type' => 'pickup'))) ?>">
                                    <?php echo $this->Html->image('pickup_green.png', array('width' => '30')); ?>
                                </a>
                            </td>
                        </tr>
                </table>
				
			</div>			
                <div id="gradient_bottom_border">  </div>
                
                <?php if ((($this->Session->read('Order.Order.subtotal') - $this->Session->read('Order.Order.delivery_charge') < $minOrder))) : ?>
                <!-- Minimum for ordering not reach -->
                <div style=" float: left; width: 100%;">
                    <div id="minimum_delivery">
                        <?php echo __('Min. Order for delivery is %s', "<span class='nowrap'>" . $this->Number->currency($minOrder, $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')) . "</span>"); ?>
                    </div>             
                </div>
                <?php elseif (!is_numeric($minOrder) || $this->Session->read('Order.Order.type') === 'pickup'): ?>
                <!-- Unknow postal code message -->
                <div style=" float: left; width: 100%;">
                    <div id="minimum_delivery">
                        <?php echo __('Delivery charge and order minimum may apply depending on your postal code'); ?>
                    </div>             
                </div>
                
                <?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>				

	
	<div style="width: 100%">
		<h1 style="margin-top: 0">
			<?php echo $location['Location']['name']; ?>
		</h1>			

		<div id="restaurant-img" style="width: 95%; margin: auto; text-align: center;">
			<?php 
				$image = $this->Image->out($location['Location']['logo'], '514x514', TRUE, FALSE, FALSE, array('width' => '100%',)); 
				if($image){
					echo $image;	// if 514x514 image output this one
				}else{
					echo $this->Image->out($location['Location']['logo'], '120x120', true, false, FALSE, array('width' => '100%',)); // output smaller image or nothing
				}
			?>

		</div>

			<div class="fl_left mT25 mL25">
				<?php if (!$isPdfLocation): ?>
					<?php if ($isDelivering): ?>
						<p class="strong"><?php echo __('This location is currently open'); ?></p>					
					<?php else: ?>
						<p class="strong"><?php echo __('This location is currently close'); ?></p>	
					<?php endif; ?>	
				<?php endif; ?>	

				<?php if (!empty($location['Location']['delivery_message'])){?>
				<p class="mB10">                               
					<?php $location['Location']['delivery_message']; ?>
				</p>
				<?php } ?>
				<?php if (!empty($location['Location']['conditions'])) { ?>
					<p class="mB10 strong">                
						<?php echo __('Conditions: '); ?>
					</p>
					<p class="indent">
						<?php $location['Location']['conditions']; ?>
					</p>
				<?php } ?>
				<?php if ($deliveryCharge === false) { ?>   
					<p class="mB10 strong">                
						<i class="icon-exclamation-sign"></i> <?php echo __('Delivery unavailable: '); ?>							
					</p>
					<p class="indent">
							<?php echo __('Delivery unavailable for the current postal code.<br/>Please choose a different restaurant location.') ?>               						
					</p>
				<?php }else{ ?>
					<p class="mB10 strong">
							<?php echo __('Delivery charge: '); ?>
					</p>		
					<p class="indent">
						<?php echo $this->Number->currency($deliveryCharge, $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
					</p>					
				<?php }?>


			</div>

				<br/>
				<br/>
				<br/>
				<br/>
				<br/>

				<div class="clear"></div>


				<div class="tabbable full-width-tabs">

					<!-- MENU -->
					<div id="contentMenu">
					<?php
					if ($is_mobile) {
						$itemAjax = '';
						$target = '_self';
					} else {
						$itemAjax = 'item-ajax';
						$target = '_self';
					}
					?>
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

						<!--<div class="accordion" id="accordion2">--> <!-- uncommenting this will only allow one category to be expanded at the time-->
						<!-- Tip the driver -->

                        <?php // Remove Tips for one restaraurant //TODO add a field in the locations table for "tip is enable" to replace this crap?>
                        <?php if ( $location['Location']['id'] !== '528103ac-ddb8-43d3-a714-6a881ec880c8' && $location['Location']['id'] !== '52810422-1690-4e06-8946-6a881ec880c8'): ?>
						<div class="accordion-group">
							
							<a class="accordion-toggle" data-toggle="collapse" href="#collapse<?php echo $i; ?>">
									<div class="accordion-heading category-no-image">					
										<div class="caption caption-no-image">	
											<p>
												<?php echo __('Tip the driver'); ?>
											</p>
											<div class="open_icon">
											<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>
											</div>
										</div>						
									</div>
								</a>
																									
							<div id="collapse<?php echo $i; ?>" class="accordion-body collapse in">
								<div class="category-description">
									<p>
										<?php echo __('Include the drivers tip directly in your order'); ?>
									</p>
								</div>
								<ul id="tip_ul" class="menu" >
									<?php foreach ($tipOptions as $tipOption) :?>
									<a href="<?php echo Router::url(array(
											'controller' => 'tipOptions',
											'action' => 'add_to_order',
											$tipOption['TipOption']['amount'],
											$location['Location']['id']))?>"
									   target = "_self"
									   class = 'add_tip' 
									   tip_amount = '<?php echo number_format((float) $tipOption['TipOption']['amount'], 2, '.', ''); ?>'>
										<li class="odd alternate"> 
											<span class="writeLeft"><?php echo __('Tip') ?></span>&nbsp;
											<span class="writeRight">
												<?php echo $this->Number->currency($tipOption['TipOption']['amount'], $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2')) ?>
											</span>
										</li>
									</a>

									<?php endforeach; ?>
								</ul>

							</div>
						</div>
                        <?php endif; ?>

						<!-- Menu Item Grouped by Menu-groups -->
						<?php
						foreach ($categories as $category) {
							$i++;
							?>
							<div class="accordion-group">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
									<div class="accordion-heading category-no-image">					
										<div class="caption caption-no-image">	
											<p>
												<?php echo $category['MenuCategory']['name']; ?>												
											</p>
											<div class="open_icon">
											<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>
											</div>
										</div>						
									</div>
								</a>
								<div id="collapse<?php echo $i; ?>" class="accordion-body collapse">
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

	//												$imgTag = '';
	//												if (!empty($item['MenuItem']['image'])) {
	//													$imgTag = $this->Html->image('BOUTONS/has_image.png', array(
	//														'class' => 'add_basket',
	//														'title' => __('Show items genuine photo')));
	//												}


													// the controller will check if option exist for this item
													echo $this->Html->link(
														$this->Html->tag(
															'li', "<span class='writeLeft'>" .
															$item['MenuItem']['name'] .
															"</span>&nbsp;<span class='writeRight'>" .
															$priceString .
															"</span>", array('class' => 'odd alternate')), array(
														'controller' => 'menuItems',
														'action' => 'options_modal',
														$item['MenuItem']['id']), array(
														'target' => $target,
														'escape' => false));
												}
											}
										
										?>
									</ul>
								</div>
							</div>
						<?php } ?>




						<!-- //TODO Display any items not in a category -->            



						<!--</div>-->
					 <?php } else { ?>
						<!-- No menu where found -->
                        <?php 
                        
                        // NO ONLINE ORDERING 
                        
                        // a few restaurant have two versions of there page (one PDF one online) and are indexed so we need to keep does pdf version. 
                        // Here we are adding a link to the online version to those restaurans apges
                        switch($location['Location']['id']){
                            case '528103af-350c-45a7-a0fd-6a881ec880c8': ?>
                        
                        <a href="http://www.topmenu.com/en/restaurant/rosemont-west/o-fuzion"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '528103d3-b9ac-4cc7-8abc-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/hochelaga/rice-box" role='button' class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        
                       <br/>                   
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '5281041e-4e90-4daa-ab1b-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/aiko-sushi"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                       <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810424-440c-4ee5-8140-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/centre-sud/tabla-village"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '528104ad-a278-49bd-b647-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/snowdon-upper-westmount-cote-des-neiges/pizza-mima"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810523-9530-4c3f-80df-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/salonica"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php case '52810558-cda4-43eb-a059-6a881ec880c8': ?>
                                                
                        <a href="http://www.topmenu.com/en/restaurant/plateau-mont-royal/ambala"  class="btn btn-success" style="margin-right:5px;margin-left:5px;" target="_self">
                            <?php echo __('Order online'); ?>
                        </a>
                        <br/>                       
                        <?php echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu',    'class' => "pull-right"), __('Open the PDF Menu')); ?>						
                        <script>$('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });</script>
                        <?php break; ?>
                        
                        <?php 
                        
                        // back to normal locations
                        default:
                            if (!empty($location['Location']['pdf_menu'])) : ?>
                        
                              <?php  
                                echo $this->PDF->out($location['Location']['url'], array('id' => 'downloadPdfMenu','class' => "btn btn-success", 'style' => 'margin: 0 5px'), __('Open the PDF Menu'));
                                echo $this->Html->link($location['Location']['phone'], "tel:{$location['Location']['phone']}", array('id'=> 'restoCall', 'class' => "btn btn-success pull-right", 'style' => 'margin: 0 5px'));?>
                                <script>
                                    $('#downloadPdfMenu').on('click', function() { ga('send', 'event', 'link', 'PDF-Desktop', '<?php echo $location['Location']['name']; ?>');  });
                                    $('#restoCall').on('click', function() { ga('send', 'event', 'phone-link', 'resto-call', '<?php echo $location['Location']['name']; ?>');  });
                                </script>
                                
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
</div>
</div>

<?php if($location['Location']['online_ordering']): ?>
<script type="text/javascript">ga('set', 'contentGroup1', 'Online Restaurant Pages');</script>
<?php endif; ?>

<?php
// Empty form use to to call action //TODO: this is ugly
echo $this->Form->create(null,array(
	'url' => array(				
		'controller' => 'locations',
		'action' => 'set_order_type', 
		'type' => 'delivery',
		'locationUrl' => $location['Location']['url'],
		'locationId' => $location['Location']['id']),
	'type' => 'post',
	'id' => 'delivery')); 
echo $this->Form->end();
echo $this->Form->create(null,array(
	'url' => array(				
		'controller' => 'locations',
		'action' => 'set_order_type', 
		'type' => 'pickup',
		'locationUrl' => $location['Location']['url'],
		'locationId' => $location['Location']['id']),
	'type' => 'post',
	'id' => 'pickup')); 
echo $this->Form->end();



echo $this->Html->css('jquery-ui' . DS . 'jquery-ui-1.10.3.custom.min.css', 'stylesheet', array('inline' => false));
echo $this->Html->script('location_tabs');
echo $this->Html->script('item-modal-mobile');
echo $this->Html->css('search_box-mobile', 'stylesheet', array('inline' => false));	
echo $this->Html->script('options_modal_form');
echo $this->Js->writeBuffer();
echo $this->Html->script('please_wait');