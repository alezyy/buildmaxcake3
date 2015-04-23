<!-- RESTAURANT INFO -->

<div class="row_mobile row <?php echo $add_botom_border; ?>">
	<div id="checkout_logo">
		<?php echo $this->Image->out($location['Location']['logo'], '120x120', true, false, FALSE, array('width' => '100%')); ?>
	</div>
	<div id="checkout_restaurant_info">
		<p class="strong" style="margin-bottom: 0"><?php echo $location['Location']['name'] ?></p>
		<p class="weak"><?php echo $location['Location']['short_address'] ?></p>
	</div>
</div>