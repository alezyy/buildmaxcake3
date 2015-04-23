
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Session->flash(); ?>

<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Password Reset'); ?>
    </div>
</div>
		
<?php echo $this->Form->create('User');?>
<div class="row_mobile row mobile_default_form">
    <div class="form_input_label">
        <label for="UserForgotEmail"><?php echo __('Email Address')?><sup class="red">*</sup></label>                	    
	    <?php
	        echo $this->Form->input('User.forgot_email', 
                array('label' => false, 'div' => false, 'no_div' => true, 'type' => 'email'));
	    ?>
    </div>
</div>

<div class="row row_emphasis">
    	<?php
		echo $this->Form->end(array(
			'label' => __('Reset Password!'),
			'class' => 'btn btn-success',));
		?>
</div>
<?php
$this->Html->script('provinces', array('inline' => false));