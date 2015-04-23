<?php

$RATING_MIN_STARS = 0;
$RATING_MAX_STARS =5;
$RATING_PRECISION = 1;  // start fractions
?>



<div id="rating" class="rating_box">
    <?php if (empty($stars)) { ?>
        <?php echo __('Be the first to rate this restaurant\'s location'); ?> </br>
    <?php } else { ?>
        <?php echo __('Rate this restaurant\'s location'); ?> </br>
    <?php } ?>
    <input 
        type="range" 
        value="<?php echo $stars ?>" 
        step="<?php echo $RATING_PRECISION ?>" 
        id="backing4">
    <div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false" data-rateit-ispreset="true"
         data-rateit-min="<?php echo $RATING_MIN_STARS ?>" data-rateit-max="<?php echo $RATING_MAX_STARS ?>">
    </div>
    <?php 
    // link set only to provide link to ajax
    echo $this->Html->link(
        '',
        array(
            'controller' => 'ratings',
            'action' => 'add_rating',
            $locationId,
                $userId),
        array('id' => 'rating_link' )); 
    ?>
    
    
</div>

<?php echo $this->Html->script('jquery.rateit.min.js'); ?>
<?php echo $this->Js->writeBuffer();?>