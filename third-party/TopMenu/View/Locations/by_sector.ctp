<div id="content_inner">

    <?php echo $this->element('by_sector_element', array('cache' => true)); ?>
    <!-- Left Container Ends -->


    <!-- Right Container Starts -->
    <div id="contentAjax">
    <?php echo $this->element('by_sector_content'); ?>
    </div>

<?php
echo $this->Html->script('by_sector');
echo $this->Js->writeBuffer();