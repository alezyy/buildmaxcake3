<?php echo $this->Html->css('jquery-ui' . DS . 'jquery-ui-1.10.3.custom.min.css'); ?>
<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Order Approved'); ?></h1>
		</div>
	</div>

	<div class="location_view">
		<p><?php echo __("Thank you on the behalf of %s and %s!", array($location['Location']['name'], $siteName)); ?></p>
		<p><?php echo __("The invoice and order confirmation was sent to you by email."); ?></p>
		
		<?php if ($orderIsDelayed) { ?>
		<p>
			<?php 
			echo __('Your order is set to arrive on: ');
			echo $this->Date->formatDate($this->Session->read('Order.Order.requested_for'));
			?>
		</p>
		<?php } else { ?>
		<p>
			<?php echo $response_string; ?>
		</p>
		<p><?php echo __("Bon appetit!"); ?></p>
		<?php } ?>
	</div>

</div>


<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Location\'s address'); ?></h1>
		</div>
	</div>

	<div class="location_view">
		<span class="strong"><?php echo $location['Location']['name'] ?></span><br/>
		<?php echo $location['Location']['phone'] ?>,<br/>
		<?php echo $location['Location']['building_number'] ?>&nbsp;		
		<?php echo $location['Location']['street'] ?>,<br/>
		<?php echo $location['Location']['city'] ?>&nbsp;
		(<?php echo $location['Location']['province'] ?>)<br/>
		<?php echo $location['Location']['postal_code'] ?><br/>
	</div>

</div>