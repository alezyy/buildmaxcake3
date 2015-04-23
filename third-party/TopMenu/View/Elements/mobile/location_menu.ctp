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
if (!empty($items)) {
	?>

	<!--<div class="accordion" id="accordion2">--> <!-- uncommenting this will only allow one category to be expanded at the time-->
	<!-- Tip the driver -->

	<div class="accordion-group">
						<!--<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">-->
		<a class="accordion-toggle" data-toggle="collapse" href="#collapse<?php echo $i; ?>">
			<div class="accordion-heading category-no-image">					
				<div class="caption caption-no-image">	
					<p>
						<?php echo __('Tip the driver'); ?>
						<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
					</p>
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
				<?php
				foreach ($tipOptions as $tipOption) {

					echo $this->Html->link(
						$this->Html->tag(
							'li', "<span class='writeLeft'>" .
							__('Tip') .
							"</span>&nbsp;<span class='writeRight'>" .
							$this->Number->currency($tipOption['TipOption']['amount'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')) .
							"</span>", array('class' => 'odd alternate')), array(
						'controller' => 'tipOptions',
						'action' => 'add_to_order',
						$tipOption['TipOption']['amount'],
						$location['Location']['id']), array(
						'class' => 'window-open',
						'rel' => 'nofollow',
						'escape' => false));
				}
				?>
			</ul>

		</div>
	</div>

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
							<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
						</p>
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
				// Categories with sizes
				if (array_key_exists($category['MenuCategory']['id'], $categoriesSizes)) {
					$j = 0;
					foreach ($categoriesSizes[$category['MenuCategory']['id']] as $size) {
						?>
						<div class="accordion-group-smaller">
							<a class="accordion-toggle" data-toggle="collapse" href="#collapseSize<?php echo $j; ?>">
								<div class="accordion-heading category-no-image-smaller">		
									<div class="caption-smaller caption-no-image-smaller">	
										<p>
											<?php echo $size[0]; ?>
				<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
										</p>
									</div>						
								</div>
							</a>
							<div id="collapseSize<?php echo $j; ?>" class="accordion-body collapse smaller">
								<ul id="menu_ul" class="menu" >	

									<?php
									foreach ($items as $item) { // iterate all the items withing this group						
										if ($item['MenuItem']['menu_category_id'] === $category['MenuCategory']['id'] && $item['MenuItem']['size'] == $size[0]) {
											if (!empty($item['MenuItem']['no_price_text'])) {
												$priceString = $item['MenuItem']['no_price_text'];
											} else {
												$priceString = $this->Number->currency($item['MenuItem']['price'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
											}

											$imgTag = 'test';
											if (!empty($item['MenuItem']['image'])) {
												$this->Html->image('BOUTONS/has_image.png', array(
													'class' => 'add_basket',
													'title' => __('Show items genuine photo')));
											}


											// the controller will check if option exist for this item
											echo $this->Html->link(
												$this->Html->tag(
													'li', "$imgTag <span class='writeLeft'>" .
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

									$j++;
									?>
								</ul>
							</div>
						</div>
					<?php } ?>										
					<div class="accordion-group-smaller">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSize<?php echo $j; ?>">
							<div class="accordion-heading category-no-image-smaller">	
								<div class="caption-smaller caption-no-image-smaller">	
									<p>
										<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
									</p>
								</div>						
							</div>
						</a>
						<div id="collapseSize<?php echo $j; ?>" class="accordion-body collapse smaller">
							<ul id="menu_ul" class="menu" >	
								<?php
								foreach ($items as $item) { // iterate all the items withing this group		
									if ($item['MenuItem']['menu_category_id'] === $category['MenuCategory']['id']) {

										if ($item['MenuItem']['size'] === NULL) {

											if (!empty($item['MenuItem']['no_price_text'])) {
												$priceString = $item['MenuItem']['no_price_text'];
											} else {
												$priceString = $this->Number->currency($item['MenuItem']['price'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
											}

											$imgTag = 'test';
											if (!empty($item['MenuItem']['image'])) {
												$this->Html->image('BOUTONS/has_image.png', array(
													'class' => 'add_basket',
													'title' => __('Show items genuine photo')));
											}


											// the controller will check if option exist for this item
											echo $this->Html->link(
												$this->Html->tag(
													'li', "$imgTag <span class='writeLeft'>" .
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
								}
								?>
							</ul>
						</div>
					</div>
			<?php
		}

		// Sizeless Categories
		else {
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

							$imgTag = '';
							if (!empty($item['MenuItem']['image'])) {
								$imgTag = $this->Html->image('BOUTONS/has_image.png', array(
									'class' => 'add_basket',
									'title' => __('Show items genuine photo')));
							}


							// the controller will check if option exist for this item
							echo $this->Html->link(
								$this->Html->tag(
									'li', "$imgTag <span class='writeLeft'>" .
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
	<div class="accordion" id="accordion2"> 
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
	<?php echo __('No menu where found'); ?>
				</a>
			</div>
		</div>
	</div>
<?php } ?>								
<?php echo $this->Html->script('please_wait'); ?>

<div id="option">

</div>