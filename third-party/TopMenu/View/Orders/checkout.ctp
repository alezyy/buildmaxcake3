<div class="row col-md-7 container-white">
	<div class="row" id="addresses">	
		<?php echo $this->element('checkout/addresses', array($currentAddress, $deliveryAddresses)); ?>
	</div>
	<div class="panel-group space-10" id="accordion-checkout" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion-checkout" data-target="#collapseOne">
			  <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			    	<?php echo __('Add New Address'); ?> 
			    </a>
			    <i class="fa pull-right indicator fa-plus"></i>
			  </h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					<?php echo $this->element('checkout/add_delivery_address_form'); ?>
				</div>
			</div>
		</div>
	</div>
</div>


	<!-- Start checkout Right sidebar -->
	<div class="col-md-5 sidebar">
		<div class="page-header text-red">
			<h1><b><?php echo __('Your Order') ?></b></h1>
		</div>

		<!-- Delivery or Pickup radio Buttons -->
		<div>
			<div class="col-md-4">
				<?php echo $this->Image->out($location['Location']['logo'], '250x250', true, false, FALSE, array('class' => 'img-responsive', 'width' => '120', 'height' => 'auto')); ?>
			</div>
			<div class="col-md-8">
				<h4><?php echo  $location['Location']['name'] ?></h4>
				<h4><small><?php echo  $location['Location']['short_address'] ?></small></h4>

				<p>
					<?php echo ($this->Session->read('Order.Order.type') === 'delivery') ? __('Your order is for delivery') : __('Your order is for takeout'); ?>
				</p>
				<h5 class="">
					<?php if($this->Session->read('Order.Order.type') === 'delivery'): ?>
						<label class="radio-inline">
							<input type="radio" name="OrderType" value="delivery" checked/><?php echo __('Delivery'); ?>
						</label>
						<label class="radio-inline">
							<input type="radio" name="OrderType" value="pickup" onclick="javascript:window.location.href='<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'type' => 'pickup', 'language' => $langSuffix)); ?>'; return false;" /><?php echo __('Pickup'); ?>
						</label>
					<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="OrderType" value="delivery" onclick="javascript:window.location.href='<?php echo Router::url(array('controller' => 'orders', 'action' => 'checkout', 'type' => 'delivery', 'language' => $langSuffix)); ?>'; return false;" /><?php echo __('Delivery'); ?>
						</label>
						<label class="radio-inline">
							<input type="radio" name="OrderType" value="pickup" checked /><?php echo __('Pickup'); ?>
						</label>
					<?php endif; ?>
				</h5>
			</div>
			
		</div>
	</div>
</div>