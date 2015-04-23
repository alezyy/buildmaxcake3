
<div class="row_mobile row row_emphasis add_botom_border">
    <p class="strong">
        <?php echo __('Order NOT approved'); ?>
    </p>
</div>




<div class="row_mobile">
    <?php echo __("Sorry the transaction was cancelled."); ?>
</div>

<?php if (!empty($location_response)) { ?>
    <div class="row_mobile">
        <?php echo __('Here\'s the restaurant response: ') ?>
        <br/>
        <?php echo '"' . $location_response . '"' ?>
    </div>
<?php } ?>
