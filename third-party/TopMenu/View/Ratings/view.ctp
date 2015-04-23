<?php
$i = 0; // $counter for collaspsing div    
?>

    <?php if (!empty($reviews)) : ?>
	<div class="row space"> 
        <?php foreach ($reviews as $review) : ?> 
    		<blockquote class="blockquote">
    			<form class="pull-right"><input id="input-5a" class="rating" data-disabled="true" disabled="true" value="<?php echo $review['Rating']['rating'] ?>"></form>
		    	<?php if(empty($review['Rating']['review'])):
						echo __('No review');
				endif; ?>
		    	<p><?php echo nl2br(h($review['Rating']['review'])); ?></p>
		    	<footer><?php echo $this->Date->formatDate($review['Rating']['created']); ?> ------------ <cite class="text-red" title="Source Title"><?php echo $review['Profile']['first_name'] ?></cite></footer>
		    </blockquote>
        <?php endforeach; ?>
	</div>
    <?php else :?>
	
		<p class=""><small><?php echo __('There are currently no comments for this restaurant.'); ?></small></p>

	<?php endif; ?>