<div class="page-header">
	<h1><?php echo __('Register'); ?></h1>
</div>

<?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'register col-xs-12 col-md-6 panel panel-default', 'action' => 'register', 'id' => 'registerForm')); ?>
<div class="form-group col-xs-12 col-md-6">
    <?php echo $this->Form->input('Profile.first_name', array(
        'type' => 'text',
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('First Name'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
    )); ?>
</div>
<div class="form-group col-xs-12 col-md-6">
    <?php echo $this->Form->input('Profile.last_name', array(
        'type' => 'text',
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('Last Name'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
    )); ?>
</div>
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
<div class="form-group col-xs-12 col-md-6">
    <?php echo $this->Form->input('User.password', array(
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('Password'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
    )); ?>
</div>
<div class="form-group col-xs-12 col-md-6">
    <?php echo $this->Form->input('User.password_confirm', array(
                    'placeholder'  => __('Confirm Password'),
                    'type'         => 'password',
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                    'equalto' => 'UserPassword',
                    'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                )); ?>
</div>
<div class="form-group col-xs-12">
    <?php echo $this->Form->input('Profile.phone', array(
                    'placeholder'  => __('Phone'),
                    'type'         => 'tel',
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                    'required' => 'required',
                    'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                )); 

        echo $this->Form->hidden(
            'Profile.timezone',
            array('value' => 'America/Montreal')
        );
    ?>
</div>
<div class="form-group col-xs-12">
    <?php echo $this->Form->submit(__('Sign Up!'), array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'registerFormSubmit')); ?>
</div>
 <?php echo $this->Form->End(); ?>

<div class="col-xs-12 col-md-5 col-lg-5 pull-right text-right panel panel-default" id="steps">
    <a href="/<?php echo $langSuffix ?>/faq"> 
        <h2 class="text-red">
            <span class=""><?php echo __('How does'); ?></span><br/>
            <span class=""><?php echo __('it work?'); ?></span>
        </h2>
        <div class="col-xs-10">
            <h1><strong><?php echo __('1.'); ?></strong></h1>
            <p><?php echo __('Enter your postal code'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/code-postal.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Code postal",
    "title" => "Code postal"
                )
            ); ?>
        </div>
        <div class="col-xs-10">
            <h2><strong><?php echo __('2.'); ?></strong></h2>
            <p><?php echo __('Choose a restaurant'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/choix.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Choix"
                )
            ); ?>
        </div>   
        <div class="col-xs-10">
            <h3><strong><?php echo __('3.'); ?></strong></h3>
            <p><?php echo __('Confirm your order'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/commande.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Commande"
                )
            ); ?>
        </div>
    </a>     
</div>

<?php echo $this->element('password_meter');
    echo $this->Html->script('password_meter', array('inline' => false)); ?>