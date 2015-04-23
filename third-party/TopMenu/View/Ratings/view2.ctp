<?php
$i = 0; // $counter for collaspsing div    
?>

    <?php if (!empty($reviews)) : ?>
<div class="accordion" id="accordion2"> 
        <?php foreach ($reviews as $review) : ?>     
                <div class="accordion-group">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo ++$i; ?>">
						<div class="accordion-heading category-no-image">					
							<div class="caption caption-no-image">	
								<p>
									<?php echo $this->element('rating_stars_readonly', array('stars' => $review['Rating']['rating'])); ?>
									<?php echo $this->Html->image('icon_collapsible.png', array('class' => 'icon_collapsible')); ?>						
								</p>
							</div>						
						</div>
					</a>  
					

                    <div id="collapse<?php echo $i; ?>" class="accordion-body collapse">
                        <div class="accordion-inner">
							<?php if(empty($review['Rating']['review'])):
								echo __('No review');
							endif; ?>
                            <?php echo nl2br(h($review['Rating']['review'])); ?>
                            <br/>
                            <br/>
                            <?php echo $review['Profile']['first_name'] ?>
                            <br/>
							<?php echo $this->Date->formatDate($review['Rating']['created']); ?>

                        </div>
                    </div>
                </div>	
            <?php endforeach; ?>
	</div>
    <?php else :?>
	
		<?php echo __('There are currently no comments for this restaurant.'); ?>

	<?php endif;