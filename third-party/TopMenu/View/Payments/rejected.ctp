<?php echo $this->Html->css('jquery-ui' . DS . 'jquery-ui-1.10.3.custom.min.css'); ?>
<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1><?php echo __('Order NOT approved'); ?></h1>
		</div>
	</div>

	<div class="location_view">
		<p><?php echo __("Sorry the transaction was cancelled."); ?></p>
		<?php if (!empty($location_response)){ ?>
		<p><?php echo __('Here\'s the restaurant response: ') ?></p>
		<p><?php echo '"'.$location_response.'"' ?></p>
		<?php } ?>
		
	</div>

</div>