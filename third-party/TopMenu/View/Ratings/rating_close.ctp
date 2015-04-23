<div id="content_inner">
	<div class="other_center">
		<div class="gray_head_box">
			<div class="gray_head_heading">
                <h1><?php echo __('Sorry, only one review per order.') ?></h1>
			</div>
		</div>
		<div class="location_view">
			<?php echo __("Here's the review you already made"); ?> 
            <p><?php echo $this->element('rating_stars_readonly', array('stars' => $rating['Rating']['rating'])); ?></p><br/>
            <p><?php echo $rating['Rating']['review'] ?></p><br/>
            <p><?php echo $this->Date->formatDate($rating['Rating']['created']); ?></p>
		</div>		
	</div>
</div>

<?php echo $this->Html->css('rateit.css', null, array('block' => 'css')); ?>
<?php echo $this->Html->script('jquery.rateit.min.js'); ?>
<?php echo $this->Js->writeBuffer();
