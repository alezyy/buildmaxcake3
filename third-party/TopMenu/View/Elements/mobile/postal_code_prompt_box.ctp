<?php if (!$this->Session->check('DeliveryDestination') && !$isPdfLocation && $is): ?>

    <?php $defaultPc = substr($location['Location']['postal_code'], 0, 3); ?>
    <script type="text/javascript">

        /**
         * we need the users postal to know if the restaurant can delivery to this area
         */

        var result = prompt("<?php echo __('Please enter your postal code to know if the restaurant delivery to your area.\nLeave empty for pickup.'); ?>");
        if (result) {
            window.location = '/locations/add_postal_code/' + encodeURI(result) + '/' + '<?php echo $defaultPc; ?>' + '/<?php echo $location['Location']['id']; ?>';
        } else {
            window.location = '/locations/add_postal_code/0/<?php echo $defaultPc; ?>' + '/<?php echo $location['Location']['id']; ?>';
        }
    </script>
<?php endif; ?>



<?php echo $this->element('modal/header', array('modal_id' => 'postal_code_prompt_box')); ?>

<div class="modalConfirmation_header">
    <h3><?php echo __('Your postal code'); ?></h3>
    <div id="postal_code_prompt_box_message">        
    </div>
</div>

<div class="confirmModalRow">
    <div class="control-group">
        <div class="input-append">
            <?php
            echo $this->Form->input('postal_code', array(
                'id'     => 'prompt_box-postal_code_input',
                'append' => 'append'
            ));

            echo $this->Form->button(__('OK'), array(
                'class'  => 'btn btn-success addOption',
                'type'   => 'button',
                'append' => 'append',
                'id'     => 'prompt_box-postal_code_button'));
            ?>
            <div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
        </div>
    </div>		
</div>
<?php
echo $this->element('modal/footer');
