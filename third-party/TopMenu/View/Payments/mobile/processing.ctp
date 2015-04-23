<div class="row_mobile row row_emphasis add_botom_border">
    <p class="strong">
        <?php echo __('Processing your order...'); ?>
    </p>
</div>

<div class="row_mobile row item">		

    <?php echo __('We are communicating with the restaurant! Please do <b>NOT</b> click your browser\'s back button!'); ?>
    <br/>
    <?php echo __('This should take less than 3 minutes <span class="small">but could take up to 5 minutes</span>'); ?>
</div>	
<div id="please_wait_big" style="
     margin: auto;
     width: 100%;
     text-align: center;">
     <?php echo $this->Html->image('ajax-loader.gif', array('alt' => __('Processing...'))); ?>
</div>

<div style="display: none; ">
    <?php
    echo $this->Html->link(
        'Action to call', array(
        'action'     => 'check_db',
        'controller' => 'payments'), array(
        'id' => 'check_db'));
    ?>

    <?php
    echo $this->Html->link(
        'success page', array(
        'action'     => 'approved',
        'controller' => 'payments',
        $orderId), array(
        'id' => 'success_page'));
    ?>

    <?php
    echo $this->Html->link(
        'rejection page', array(
        'action'     => 'rejected',
        'controller' => 'payments',
        'restaurant'), array(
        'id' => 'fail_page'));
    ?>
</div>
<?php
// pass some data to javascript
echo $this->Form->hidden('pleaseDontLeave', array(
    'id'    => 'pleaseDontLeave',
    'value' => __("WARNING!\n========\n\nThe transaction is in progress!\nYou cannot cancel the transaction by closing this page!\nPlease, wait until the transaction process finishes.\nIf you have any questions call us at 514-989-1233")
));

echo $this->Form->hidden('tiemout_delai', array(
    'id'    => 'tiemout_delai',
    'value' => $timeout
));
echo $this->Form->hidden('maxAttemps', array(
    'id'    => 'maxAttemps',
    'value' => Configure::read('Topmenu.max_attempts')
));
?>

<?php echo $this->Html->script('processing'); ?>
<?php
echo $this->Js->writeBuffer();
