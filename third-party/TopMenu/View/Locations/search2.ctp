<?php

// META TAGS //TODO put in controller
$cuisineType = '';
foreach ($cuisines as $value) {
	$cuisineType = $cuisineType . ", " . $value;
}

$commonKeywords = __('Delivery, Topmenu, Restaurants, ');
$keywords = htmlentities($commonKeywords.$cuisineType, ENT_QUOTES);
if($this->Session->check('Search.query.postal_code')){
	$metaDeliveryAreas = $this->Session->read('Search.query.postal_code');
	$this->set('meta_zipcode', "<meta name='zipcode' content='$metaDeliveryAreas' />\n");
}
elseif($this->Session->check('Search.query')){
	$metaDeliveryAreas = $this->Session->read('Search.query');
	$this->set('meta_zipcode', "<meta name='zipcode' content='$metaDeliveryAreas' />\n");
}

$this->set('meta_keywords', "<meta name='keywords' content='$keywords' />\n");
$this->set('meta_description', "<meta name='description' content='$query' />\n");
?>

<?php $this->Html->addCrumb(__('Search results'));?>
<div id="content_inner">
    <?php echo $this->element('search/element', array('cache' => true)); ?>
    <!-- Left Container Ends -->


    <!-- Right Container Starts -->
    <div id="contentAjax">	
    <?php echo $this->element('search/results', array('query' => $query)); ?>
    </div>

    <?php if (!empty($page)): ?>
    <div style="float: right; margin: 20px 1px 0 0">
        <?php
       
        // Next (max per page for each section is 10. If all of then have lest than 10 then there's not an other page)
        if (!( count($open_locations) < 10 && count($close_locations) < 10 && count($close_locations) < 10)):
                echo $this->Html->link(
                    __("Next →"), 
                    strtok($_SERVER[ 'REQUEST_URI' ]) . "?page=" . ($page + 1),
                    array('role' => 'button', 'class' => 'btn pull-right', 'style' => 'width:100px'));
        endif;

        // Previous
        if ($page > 1):
            echo $this->Html->link(
                __("← Previous"), 
                strtok($_SERVER[ 'REQUEST_URI' ]) . "?page=" . ($page - 1),
                array('role' => 'button', 'class' => 'btn pull-right', 'style' => 'width:100px'));
        endif;
        ?>
    </div>
    <?php endif; ?>
</div>