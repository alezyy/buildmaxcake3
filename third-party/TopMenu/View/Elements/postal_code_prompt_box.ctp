<?php echo $this->element('modal/header', array('modal_id' => 'postal_code_prompt_box')); ?>

<div class="modalConfirmation_header">
    <h3><?php echo __('Your postal code'); ?></h3>
</div>

<div class="confirmModalRow">
    <p id="postal_code_prompt_box_message" style="max-width: 80%; text-align: center; margin: auto;"></p>
</div>

<div class="confirmModalRow">
    <div class="control-group">
        <div class="input-append">
            <?php
            echo $this->Form->input('postal_code', array(
                'id'     => 'prompt_box-postal_code_input',
                'append' => 'append',
                'div'    => FALSE,
                'label'  => FALSE,
                'no_div' => TRUE
            ));

            echo $this->Form->button(__('OK'), array(
                'class'  => 'btn btn-success',
                'type'   => 'button',
                'append' => 'append',
                'div'    => FALSE,
                'no_div' => TRUE,
                'id'     => 'prompt_box-postal_code_button'));
            ?>            
        </div>
    </div>		
    <div class="control-group" style="min-width: 350px">
        <div class="help-inline red" style="display: none;color: red;" id="prompt_box_error_message">
            <?php echo __('Invalid Postal Code. Use one of this format: H2L or H2L 1P8'); ?>
        </div>
    </div>
</div>

<?php
echo $this->element('modal/footer');
