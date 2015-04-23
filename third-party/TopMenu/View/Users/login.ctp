<div class="page-header">
	<h1><?php echo __('Login to your account'); ?></h1>
</div>

<?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'login col-xs-12 col-md-6 panel panel-default center block', 'action' => 'login', 'id' => 'loginForm')); ?>
 <div class="form-group col-xs-12">
    <?php echo $this->Form->input('User.email', array(
        'type' => 'email',
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('Email Address'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
    )); ?>
</div>
<div class="form-group col-xs-12">
    <?php echo $this->Form->input('User.password', array(
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('Password'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
    )); 
        
        echo $this->Form->hidden('login_referer', array('value' => $this->request->referer(true)));
   	?>
</div>
<p class="form-group col-xs-12 text-center"><?php echo $this->Html->link(
			__('Forgot Password'),
			array(
				'controller' => 'users',
				'action' => 'forgot_password'
			),
			array(
				'style' => '',
			)
		); ?>
</p>
<div class="form-group col-xs-12">
    <?php echo $this->Form->submit(__('Login'), array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'loginFormSubmit')); ?>
</div>
 <?php echo $this->Form->End(); ?>

 <div class="col-xs-12 col-md-5 col-lg-5 pull-right text-right panel panel-default well">
    <div class="login_box_one offset3 span5" style="margin-top:20px;margin-bottom:20px;">
			
		<?php
		    echo $this->Html->link(
		            $this->Html->tag('h2', __('Create an account').' <i class="fa fa-arrow-right"></i>', array('class' => 'register-link')),
		            array(
						'controller' => 'users',
						'action' => 'register',
						'success' => $successPage),
					array(
						'escape' => false,
						'class' => ''
					)
				);
		?>
	    <h3>
	    	<?php echo __('Why should I sign up?'); ?>
	    </h3>
	    <ul class="list-unstyled">
			<li class="li_small"><?php echo __('Save your favorite orders'); ?></li>
			<li class="li_small"><?php echo __('Save time and order from your history'); ?></li>
			<li class="li_small"><?php echo __('Save multiple delivery addresses'); ?></li>
			<li class="li_small"><?php echo __('Create a profile and receive personalize offers'); ?></li>
	    </ul>
	</div>
</div>
