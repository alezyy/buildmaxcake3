<div class="search_wrapper">
	&nbsp;
	<div class="other_pages_left">
			<?php if ($is_tablet): // Remove affix behavior?>
				<div id="search" data-offset-top="191" data-offset-bottom="200">
			<?php else: ?>
				<div id="search" data-spy="affix" data-offset-top="260" data-offset-bottom="250">
			<?php endif; ?>	    
	        <div class="small_header_cntnr">
	            <h1 class="small_header_title"><strong><?php echo __('Search'); ?></strong></h1>
	        </div>

	        <div class="other_pages_left_tab">
	            <?php echo $this->element('search/left_bar'); ?>
	        </div>
	        <div class="left_box-shadow">&nbsp;</div>
	    </div>
	</div>
</div>
<?php
echo $this->Html->css('search_box', null, array('inline' => FALSE) );