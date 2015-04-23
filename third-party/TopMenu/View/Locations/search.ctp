<?php $this->Html->addCrumb(__('Search results'));?>
<div class="col-xs-12 no-padding" id="content">
    <?php echo $this->element('search/left_bar', array('cache' => true, 'query' => $query)); ?>
    <!-- Left Container Ends -->


    <!-- Right Container Starts -->
    <div id="" class="col-md-9 pull-right results">	
    <?php echo $this->element('search/results', array('query' => $query)); ?>
    </div>
</div>