<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Sorry, you may only do one review per order.') ?>
    </div>
</div>

<div class="row_mobile row">
    <?php echo __("Here's the review you already made"); ?> 
</div>		

<div class="row_mobile row">    
    <p><?php echo $this->element('rating_stars_readonly', array('stars' => $rating['Rating']['rating'])); ?></p><br/>
    <p><?php echo $rating['Rating']['review'] ?></p><br/>
    <p><?php echo $this->Date->formatDate($rating['Rating']['created']); ?></p>
</div>    