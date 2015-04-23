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
					
						<div class="collapsed category-image" data-toggle="collapse" data-parent="#accordion" data-target="#<?php echo $category['MenuCategory']['id'] ?>" style="background-image:url(<?php echo $this->Image->out($category['MenuCategory']['image'], '1280x1280', false, true, false);?>)">				
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
