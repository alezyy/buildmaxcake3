
<div class="mobile-featured_restaurants">
	<?php if (empty($open_locations)) : ?>
		<div class="noRecords">
			<?php echo __('Sorry! There is no restaurant open at this time.'); ?>
		</div>
	<?php else :?>
	
	
            <!-- OPEN LOCATIONS =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- --> 
        <div id="proceed_to_payment_bar">	
            <div id="greenHeaderInContent">
                    <?php echo h($query); ?>
            </div>
        </div>
 	
		
		<?php foreach ($open_locations as $location) :?>

        <div class="mobile_result_row">				
            <div class="mobile_result_row-image">
                <?php echo $this->Image->out($location['Location']['logo'], '120x120'); ?>
            </div>
            <div>
                <div class="mobile_result_row-title">
                    <h1 class="mobile_result_title">
                        <?php
                        echo $this->Html->link(
                            $location['Location']['name'], array(
                            'controller' => 'locations',
                            'action' => 'view',
                            'location' => $location['Location']['url'],
                            'sector' => $location['Location']['sector_slug']));
                        ?>     
                    </h1>
                </div>
                <div class="mobile_result_row-rating" >
                    <?php if ($location['Location']['rating'] > 0): ?>
                        <?php echo round($location['Location']['rating'],1); ?><span class="star">★</span>
                    <?php endif; ?>
                </div>
                <div class="mobile_result_row-data">

                    <?php if (!empty($location['Location']['delivery_fee'])): ?>
                        </br>
                        <?php
                        if ($location['Location']['delivery_fee']['delivery_charge'] > 0):
                            echo __('Delivery Fee: ');
                            echo $this->Number->currency($location['Location']['delivery_fee']['delivery_charge'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
                        else:
                            echo __('Free delivery');
                        endif;
                        ?>
                        <br/>
                        <?php echo $location['Location']['building_number'] ?>&nbsp;
                        <?php echo $location['Location']['street'] ?>,
                        <?php echo ucfirst(strtolower($location['Location']['city'])) ?>&nbsp;																
                    <?php endif; ?>
                </div>
            </div>
            <ul class="tags">
                <?php if (strtotime($location['Menu']['created']) > (time() - (MONTH * 3))):   // if menu was created in the last 3 months, it's a new restaurant  ?> 
                <li><a href="#" class="button_new" style=""><?php echo __('NEW'); ?></a></li>
                            <?php if (!$ccAllowedTag): ?>
                                <li>
                                    <a class="red" title="<?php echo __('This restaurant is currently not accepting credit cards'); ?>"  href="#">
                                        <?php echo __('NO Credit Cards'); ?>
                                    </a>
                                </li>    
                            <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>

		<?php endforeach; ?>
	<?php endif; ?>
		
	 <?php if (!empty($close_locations)): ?>
		<h4 class="red">
			<?php echo __('The following restaurants are presently closed:'); ?>
		</h4>		
		
		<!-- CLOSED LOCATIONS =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- --> 
		<?php foreach ($close_locations as $location) :?>

			<div class="mobile_result_row">				
					<div class="mobile_result_row-image">
						<?php echo $this->Image->out($location['Location']['logo'], '120x120'); ?>
					</div>
					<div class="mobile_result_row-title">
						<h1 class="mobile_result_title">
							<?php
							echo $this->Html->link(
								$location['Location']['name'], array(
									'controller' => 'locations',
									'action' => 'view',
									'location' => $location['Location']['url'],
									'sector' => $location['Location']['sector_slug']));
							?>     
						</h1>
					</div>
					<div class="mobile_result_row-rating" >
						<?php if($location['Location']['rating'] > 0): ?>
							<?php echo round($location['Location']['rating'],1); ?><span class="star">★</span>
						<?php endif; ?>
					</div>
				<div class="mobile_result_row-data">
						
					<?php if (!empty($location['Location']['delivery_fee'])): ?>
					</br>
					<?php 
					if ($location['Location']['delivery_fee']['delivery_charge'] > 0 ):
						echo __('Delivery Fee: ');
						echo $this->Number->currency($location['Location']['delivery_fee']['delivery_charge'], $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
					else: 
						echo __('Free delivery');
					endif;
					?>
					<br/>
					<?php echo $location['Location']['building_number'] ?>&nbsp;
					<?php echo $location['Location']['street'] ?>,
					<?php echo ucfirst(strtolower( $location['Location']['city'])) ?>&nbsp;																
				<?php endif; ?>
				</div>
					
				<ul class="tags">
                    <?php if (strtotime($location['Menu']['created']) > (time() - (MONTH * 3))):   // if menu was created in the last 3 months, it's a new restaurant  ?> 
                    <li><a href="#" class="button_new" style=""><?php echo __('NEW'); ?></a></li>
                    <?php endif; ?>
                    <li><a class="gray" href="#"><?php echo __('Currently closed'); ?></a></li>                    
                </ul>
                                                                
			</div>

		<?php endforeach; ?>

	<?php endif; ?>
        
        <?php if (!empty($pdf_locations)): ?>
		<h4 class="red">
			<?php echo __('The following restaurants do not offer online orders'); ?>
		</h4>		
		
		<!-- PDF LOCATIONS =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- --> 
		<?php foreach ($pdf_locations as $location) :?>

			<div class="mobile_result_row">				
					<div class="mobile_result_row-image">
						<?php echo $this->Image->out($location['Location']['logo'], '120x120'); ?>
					</div>
					<div class="mobile_result_row-title">
						<h1 class="mobile_result_title">
							<?php
							echo $this->Html->link(
								$location['Location']['name'], array(
									'controller' => 'locations',
									'action' => 'view',
									'location' => $location['Location']['url'],
									'sector' => $location['Location']['sector_slug']));
							?>     
						</h1>
					</div>
				<div class="mobile_result_row-data">					
					
					<?php if (!empty($location['Location']['delivery_fee'])): ?>
					</br>
					<?php 
					if ($location['Location']['delivery_fee']['delivery_charge'] > 0 ):
						echo __('Delivery Fee: ');
						echo $this->Number->currency($location['Location']['delivery_fee']['delivery_charge'], $this->request->language .  '_' . Configure::read('I18N.COUNTRY_CODE_2'));
					else: 
						echo __('Free delivery');
					endif;
					?>
					<br/>
					<?php echo $location['Location']['building_number'] ?>&nbsp;
					<?php echo $location['Location']['street'] ?>,
					<?php echo ucfirst(strtolower( $location['Location']['city'])) ?>&nbsp;																
				<?php endif; ?>
                                         
				</div>                
                                    
                <ul class="tags">
                    <?php if (strtotime($location['Menu']['created']) > (time() - (MONTH * 3))):   // if menu was created in the last 3 months, it's a new restaurant  ?> 
                    <li><a href="#" class="button_new" style=""><?php echo __('NEW'); ?></a></li>
                    <?php endif; ?>
                    <li><a class="green" href="#"><?php echo __('PDF only'); ?></a></li>
                </ul>
                                                                
			</div>

		<?php endforeach; ?>

	<?php endif; ?>
</div>

<?php
$ratings = Configure::read('Topmenu.ratings');
if ($ratings) {
	echo $this->Html->script('jquery.raty', array('inline' => false));
}