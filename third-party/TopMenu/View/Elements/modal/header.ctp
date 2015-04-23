<?php echo $this->Html->css('jquery-ui' . DS . 'jquery-ui-1.10.3.custom.min.css'); ?>
<?php $boxId = (empty($modal_id)) ? 'modalConfirmation' : $modal_id; ?>

<div id="<?php echo $boxId ?>"  class="modal hide fade modalCustom" tabindex="-1" role="dialog" aria-labelledby="modalConfirmation" aria-hidden="true"
     onshow="$(function(){
    // Select the div
    var div = $('#modalConfirmation');
    // Get the width;
    var width = div.outerWidth();
    var windowWidth = $(document).width();
    var total = (windowWidth - width);
    // Change the margin-left to half negative
    div.css({'marginLeft' : -(total / 2) + 'px'});
    div.css({'left' : Math.abs(total) + 'px'});
    total = null;    
});">
	
    <a href="javascript:void(0)" class="close_button" onclick="$('#<?= $boxId ?>').modal('hide'); return false;">        
		<?php echo $this->Html->image('checkout/modal_close_button.png', array('id' => 'modal_close_button')); ?>        
	</a>
	<div class="modal-border">
        <div class="modalConfirmation_inner">


