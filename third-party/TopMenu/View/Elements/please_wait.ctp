<?php $display = (empty($display)? '': $display); ?>
<div id="please_wait_spinner" <?php echo $display ?> style="z-index: 2000">
	<?php echo $this->Html->image('ajax-loader.gif') ?>
</div>