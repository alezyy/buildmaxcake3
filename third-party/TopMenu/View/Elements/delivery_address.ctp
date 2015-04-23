<div id="deliveryAddressModalForm" class="modal hide fade">

	<div class="gray_head_box">
		<div class="gray_head_heading">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">✖</button>
			<h1><?php echo __('Please choose your delivery address'); ?></h1>

		</div>
	</div>
	<div class="modal-body">
		<div>
			<div class="modalForm">		
				<?php
				if (!empty($deliveryAddresses)) {
					echo $this->Form->create('DeliveryAddress', array(
						'url' => array('controller' => 'delivery_addresses', 'action' => 'choose')));


					// success page
					if (empty($successPage)) {
						echo $this->Form->hidden('success_page', array('value' => $this->request->here));
					} else {
						echo $this->Form->hidden('success_page_controller', array('value' => $successPage['controller']));
						echo $this->Form->hidden('success_page_action', array('value' => $successPage['action']));
					}
				}
				?>

				<fieldset>
					<legend><?php echo __('Select an existing address'); ?></legend>	
					<p class="strong">
						<?php echo __('The Delivery charge can vary depending on the chosen address'); ?>
					</p>

					<div class="input-append" style="width: 100%">
						<?php
						echo $this->Form->input('deliveryAddress', array(
							'div' => FALSE,
							'no_div' => TRUE,
							'label' => FALSE,				
						));

						echo $this->Form->input(
							'OK', array(
							'class' => 'btn btn-success pull-left',
							'tabindex' => 2,
							'value' => 'OK',
							'type' => 'button',
							'label' => FALSE,
							'div' => FALSE,
							'no_div' => TRUE,
							)
						);
						?>
					</div>

					<?php echo $this->Form->end(); ?>


					<div class="modalForm" style="padding-top: 1em;">				
						<legend><?php echo __('Or add a new one'); ?></legend>	
						<?php
						echo $this->Html->link(__('Add a Delivery Address'), array(
							'controller' => 'delivery_addresses',
							'action' => 'user_add',
							$referer), array(
							'rel' => 'nofollow'));
						?>
					</div>
				</fieldset>	
			</div>



		</div>		



	</div>
</div>