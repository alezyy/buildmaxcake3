<?php echo $this->Html->css('jquery-ui' . DS . 'jquery-ui-1.10.3.custom.min.css'); ?>
<?php echo $this->element('please_wait', array('display' => "style= 'display: none;'")); ?>
<?php
$i = 0;  // display "Required choice" title only once
$j = 0;  // has not required options?
$k = 0;  // display "Extras" title only once"
$l = 0;  // number of instances
$m = 0;  // count any MenuItemOption
$hasExtras = FALSE;
?>

<input type="hidden" id="itemPrice" value="<?php echo $itemOptions['MenuItem']['price'] ?>"/>
<?php echo $this->element('current_language_for_js', array('langSuffix', $langSuffix)); ?>


<h1><?php echo $itemOptions['MenuItem']['name'] ?></h1>			

<div style="width: 100%">
	<?php if ($isAcceptingOrders === 'disabled'): ?>
		<div id="flashMessage" class="alert alert-error fade in" data-alert="alert" style=""><a class="close" data-dismiss="alert">✖</a>
			<?php echo __('This restaurant is presently not accepting online ordering on Top Menu'); ?>
		</div>
	<?php endif; ?>

	<div id="restaurant-img">
		<?php 
			$image = $this->Image->out($itemOptions['MenuItem']['image'], '514x514', TRUE, FALSE, FALSE, array('width' => '100%',)); 
		?>		
	</div>
	<div id="modal_item_description" >
		<p>
			<?php echo $itemOptions['MenuItem']['description']; ?>
		</p>
	</div>
</div>
<br/>

<div>
	<?php
	echo $this->Form->create(
		'MenuItem', array(
		'url' => array(
			'controller' => 'menuItems',
			'action' => 'add_to_order'
		),
		'id' => 'modalFormForm'));
	echo $this->Form->hidden('MenuItem.id', array('value' => $itemOptions['MenuItem']['id']));
	echo $this->Form->hidden('MenuItem.price', array('value' => $itemOptions['MenuItem']['price']));
	echo $this->Form->hidden('MenuItem.name', array('value' => $itemOptions['MenuItem']['name']));
	echo $this->Form->hidden('MenuItem.description', array('value' => $itemOptions['MenuItem']['description']));
	echo $this->Form->hidden('MenuItem.number_of_instance', array('value' => $itemOptions['MenuItem']['number_of_instance']));
	?>			

	<table class='item_option-modal'>
		<?php if ($itemOptions['MenuItem']['number_of_instance'] > 1) { ?>
			<tr>
				<td colspan="2" id="duplicateCheckbox">
					<?php echo __('Same options for all portions? '); ?>
					<?php echo $this->Form->checkbox("MenuItem.duplicate", array('id' => 'duplicateChoices', 'checked' => '')); ?>
				</td>
			</tr>
		<?php } ?>


		<!-- REQUIRED CHOICES -->
		<?php
		foreach ($itemOptions['MenuItemOption'] as $mio) {
			$m++;
			if (!empty($mio['MenuItemOptionValue'])) {
				if ($hasRequired) {
					if ($i++ === 0) {
						?>
						<tr>
							<th colspan="<?php echo $itemOptions['MenuItem']['number_of_instance']; ?>">
						<h4 ><?php echo __('Required choices'); ?></h4>
						</th>
						</tr>
					<?php } ?>
					<tr>
						<?php
						// filter out not required options							
						if ($mio['required'] === TRUE) {

							// duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
							if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
								$nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
							} else {
								$nbOfColumns = 1;
							}
							for ($l = 0; $l < $nbOfColumns; $l++) {
								$half = $l;   // input index when there is two part to the item 
								$duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
								$required = ($l > 0) ? '' : array('required' => 'required'); // do not set the duplicate optin has to required to avoid javascript exception: "An invalid form control with name='data[MenuItemOptionValues][Required][Price][1][Entities][1]' is not focusable."
								?>
								<td>			
									<?php
									
									
									if ($mio['number_of_free_values'] > 0) { // Chose more than one option value for one option
									// 
										// build array for select box without prices
										$selectOptions1 = array();
										foreach ($mio['MenuItemOptionValue'] as $miov) {
											$selectOptions1[] = array(
												'name' => $miov['name'],
												'nameonly' => $miov['name'],
												'niceprice' => $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
												'value' => $miov['id'],
												'price' => 0);
										}
										?>
										<div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>											
										<?php echo __('%s - (%d Free)', array($mio['name'], $mio['number_of_free_values'])); ?>
										</div>

											<?php
											for ($index = 0; $index < $mio['number_of_free_values']; $index++) {
												?>
											<div class="control-group">
											<?php
											// display has many select box as the amount of free item options								
											echo $this->Form->select(
												"MenuItemOptionValues.Required.Free.{$m}.Entities.{$l}.{$index}", $selectOptions1, array(
												'empty' => __('-- Select One --'),
												'class' => 'required',
												$required,
												'duplicate' => $duplicate));
											?>
												<div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
											</div>
											<br/>
						<?php }

						$selectBox = array(); // clear array
					} else { ?>

										<div class="option-modal-label" duplicate='<?php echo $duplicate; ?>' >
											<?php echo __($mio['name']); ?>
										</div>

										<?php
										// build array for select box with prices
										$selectOptions2= array();
										foreach ($mio['MenuItemOptionValue'] as $miov) {

											$selectOptions2[] = array(
												'name' => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
												'nameonly' => $miov['name'],
												'niceprice' => $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
												'value' => $miov['id'],
												'price' => $miov['price']);
										}

										// options 
										if ($mio['multiselect'] === FALSE) {
											?>

											<div class="control-group">
												<?php
												echo $this->Form->select(
														"MenuItemOptionValues.Required.Price.{$m}.Entities.{$l}",
														$selectOptions2, array(
													'empty' => __('-- Select One --'),
													'duplicate' => $duplicate,
													'class' => 'required',
													$required,
													'id' => $miov['id']));
												$selectOptions2 = array(); // clear array
												?>
												<div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
											</div>
							<?php
						}

						// extras
						else {

							// build array for select box with prices
							foreach ($mio['MenuItemOptionValue'] as $miov) {

								$selectOptions3[] = array(
									'name' => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
									'nameonly' => $miov['name'],
									'niceprice' => $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
									'value' => $miov['id'],
									'price' => $miov['price']);
							}
							?>
											<!-- //DEBUG 9.43 -->
											<div class="control-group">
												<div class="input-append">
							<?php
							echo $this->Form->select(
														'', 
														$selectOptions3, 
														array(
								'empty' => __('Select One then press -->'),
								'duplicate' => $duplicate,
								'inputId' => $m,
								'append' => 'append',
															'class' => 'required',
								$required,
								'id' => $mio['id']));

							echo $this->Form->button(
								__('+'), array(
								'class' => 'btn btn-success addOption',
								'type' => 'button',
								'duplicate' => $duplicate,
								'append' => 'append',
								'id' => 'btn_' . $mio['id']));
							$selectOptions3 = array(); // clear array
							?>
													<div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
												</div>
											</div>										
												<?php } ?>
									</td>	
					<?php } ?>						
								<?php } ?>		<!-- //DEBUG 9.53 -->				
							<?php } ?>
					</tr>
					<?php } ?>
				<?php } ?>
			<?php } ?>


		<!-- Extras -->
		<?php
		foreach ($itemOptions['MenuItemOption'] as $mio) {
			$m++;
			if (!empty($mio['MenuItemOptionValue'])) {
				if ($mio['required'] === FALSE) {
					if ($k++ == 0) {
						?>
						<tr>
							<th colspan='<?php echo $itemOptions['MenuItem']['number_of_instance']; ?>' >
						<h4 ><?php echo __('Extras'); ?></h4>
						</th>
						</tr>
			<?php } ?>
					<tr>
			<?php
			// duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
			if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
				$nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
			} else {
				$nbOfColumns = 1;
			}

			for ($l = 0; $l < $nbOfColumns; $l++) {
				$half = $l;   // input index when there is two part to the item 
				$duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
				?>
							<td>			
							<?php
							// Free items
							if ($mio['number_of_free_values'] > 0) {

								// build array for select box without prices
								foreach ($mio['MenuItemOptionValue'] as $miov) {
									$selectBox[] = array(
										'name' => $miov['name'],
										'nameonly' => $miov['name'],
										'niceprice' => $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
										'value' => $miov['id'],
										'price' => 0,
									);
								}
								?>
									<div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>
									<?php echo __('%s - (%d Free)', array($mio['name'], $mio['number_of_free_values'])); ?>
									</div>
									<?php
									for ($index = 0; $index < $mio['number_of_free_values']; $index++) {
										// display has many select box as the amount of free item options								
										echo $this->Form->select(
											"MenuItemOptionValues.NotRequired.Free.{$m}.Entities.{$l}.{$index}", $selectBox, array(
											'empty' => __('-- Select One --'),
											'duplicate' => $duplicate));
										echo "<br/>";
									}
									$selectBox = array(); // clear array
								}
								?>
							</td>
							<?php } ?>
					</tr>
						<?php
						}
					}
				}
				?>


		<!-- Priced Extras -->
<?php
foreach ($itemOptions['MenuItemOption'] as $mio) {
	if (!empty($mio['MenuItemOptionValue'])) {

		if (!$mio['required'] && $mio['number_of_free_values'] == 0) {
			if ($k++ == 0) {
				$hasExtras = TRUE;
				?>
						<tr>
							<th colspan='<?php echo $itemOptions['MenuItem']['number_of_instance']; ?>' >
						<h4 ><?php echo __('Extras'); ?></h4>
						</th>
						</tr>
			<?php } ?>
					<tr>
					<?php
					// duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
					if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
						$nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
					} else {
						$nbOfColumns = 1;
					}

					for ($l = 0; $l < $nbOfColumns; $l++) {
						$half = $l;   // input index when there is two part to the item 
						$duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
						?>
							<td>					

								<div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>
				<?php echo __($mio['name']); ?>
								</div>

				<?php
				// build array for select box with prices
				foreach ($mio['MenuItemOptionValue'] as $miov) {
					$selectOptions[] = array(
						'name' => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
						'nameonly' => $miov['name'],
						'niceprice' => $this->Number->currency($miov['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')),
						'value' => $miov['id'],
						'price' => $miov['price']);
				}
				?>

								<div class="input-append">
				<?php
				echo $this->Form->select(
					"MenuItemOptionValues.NotRequired.Price.{$m}.Entities.{$l}", $selectOptions, array(
					'empty' => __('Select One then press -->'),
					'class' => 'extras_price',
					'duplicate' => $duplicate,
					'append' => 'append',
					'half' => $l,
					'name' => FALSE,
					'id' => $mio['id'] . '-' . $l));
				echo $this->Form->button(__('+'), array(
					'class' => 'btn btn-success addOption',
					'half' => $l,
					'append' => 'append',
					'duplicate' => $duplicate,
					'type' => 'button',
					'id' => 'btn_' . $mio['id'] . '-' . $l,));
				$selectOptions = array();
				?>
								</div>										
							</td>
			<?php } ?>
					</tr>
					<?php
					}
				}
			}
			?>


		<!-- Display Users selections-->
		<tr>

			<?php for ($l = 0; $l < $itemOptions['MenuItem']['number_of_instance']; $l++) { ?>
				<td>
					<table id="extraList-<?php echo $l; ?>">																
						<tbody>
						</tbody>
						<tfoot id="extrasTotalPrice-<?php echo $l; ?>" >								
						</tfoot>
					</table>
				</td>
			<?php } ?>
		</tr>

	</table>
	<table class='item_option-modal'>

		<!-- Comment and quantity for this item -->				
		<tr>				
			<th colspan="2">									
		<h4><?php echo __('Total'); ?></h4>											
		</th>							
		</tr>



		<!-- Subtotal -->
		<?php if ($hasExtras === FALSE) { ?>

			<div class="option-modal-label-total" id="extrasTotalPriceTd" style="visibility: hidden">
				<?php echo $this->Number->currency(0, $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
			</div>
		<?php } else { ?>

			<tr>
				<td class="right" style="width: 100%;">
					<div class="option-modal-label-total">																	
						<?php echo __('Extras total: ') ?>
					</div>
				</td>
				<td class="total">
					<div class="option-modal-label-total" id="extrasTotalPriceTd">																	
						<?php echo $this->Number->currency(0, $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
					</div>
				</td>
			</tr>
		<?php } ?>
		<!-- Quantity -->
		<tr>
			<td class="right">
				<div class="option-modal-label-total">																	
					<?php echo __('Quantity: ') ?>
				</div>
			</td>
			<td class="total">

				<div class="option-modal-label-total" id='modal_option_qty_input'>																	
					<?php
					echo $this->Form->input('qty', array(
						'label' => FALSE,
						'type' => 'number',
						'div' => FALSE,
						'no_div' => TRUE,
						'id' => 'qty',
						'min' => 1,
						'max' => 99,
						'value' => 1));
					?>
				</div>
			</td>
		</tr>				

		<!-- Grand Total-->

		<tr>
			<td >
				<div class="option-modal-label-total">																	
					<?php echo __('Grand Total: ') ?>
				</div>
			</td>
			<td class="total">
				<div class="option-modal-label-total" id="grandTotal">																	
					<?php echo $this->Number->currency($itemOptions['MenuItem']['price'], $langSuffix .  '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
				</div>
			</td>
		</tr>

		<!-- Comment -->
		<tr>
			<td colspan="2">
				<?php echo __('Leave a comment to the restaurant about this item: '); ?>
				<?php echo $this->Form->textarea('comment', array('style' => 'width: 90%;')); ?>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>

		<!-- Submit Buttons -->
		<tr>
			<td colspan="2" style="">						
				<br/>

				<?php
				echo $this->Html->link(__('Cancel'), $redirectPage, array(
					'class' => 'btn btn-danger pull-left',
					'id' => 'cancelBtn',
					'role' => 'button'));
				?>
				<div id="submit-button-control" class="control-group">
				<?php
				echo $this->Form->submit(__('ADD'),array(
						'class' => 'btn btn-success pull-right',
						'id' => ($isAcceptingOrders === 'disabled') ? 'nullId' : 'submitBtn',
						$isAcceptingOrders => $isAcceptingOrders));?>
					<div id="submit-button-help" class="help-inline" style="display: none"><?php echo __('Some inputs are invalid'); ?></div>
				</div>
			</td>	
		</tr>
	</table>

<?php echo $this->Form->end(); ?>	
	<div id="contactStatus"></div>
</div>		



<?php 
echo $this->Html->script('options_modal_form');
//echo $this->Html->script('options_modal-mobile');
