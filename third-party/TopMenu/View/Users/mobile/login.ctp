<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Session->flash(); ?>

<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Login to your account'); ?>		
    </div>
</div>

<?php echo $this->Form->create('User'); ?>

<div class="row_mobile row mobile_default_form">

    <div class="form_input_label">
        <label for="UserPassword"><?php echo __('Email:'); ?>
    </div>

    <?php
    echo $this->Form->input('User.email', array(
        'label' => false,
        'div' => false,
        'no_div' => true,
        'type' => 'email',
        'placeholder' => __('Email Address')
    ));
    ?>

    <div class="form_input_label">
        <label for="UserPassword"><?php echo __('Password:'); ?>
    </div>

    <?php
    echo $this->Form->input('User.password', array(
        'label' => false,
        'div' => false,
        'no_div' => true,
        'placeholder' => __('Password')
    ));
    echo $this->Form->hidden('login_referer', array(
        'value' => $this->request->referer(true)));
    ?>
</div>

<div class="row row_emphasis">
    <?php
    echo $this->Form->end(array(
        'label' => __('Login'),
        'div' => false,
        'no_div' => true,
        'class' => 'btn btn-success',
    ));
    ?>
</div>

<div class="row row_emphasis">
    <?php
    echo $this->Html->link(
        __('Forgot Your Password'), array(
        'controller' => 'users',
        'action' => 'forgot_password'), array('class' => 'btn btn-success', 'role' => 'button'));
    ?>
</div>

<div class="row row_emphasis">
    <?php
        echo $this->Html->link(
                __('Create an account'), 
            array('controller' => 'users','action' => 'register','success' => $successPage),
            array('class' => 'btn btn-success', 'role' => 'button'));
        ?>
</div>
<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Why should I sign up?'); ?>
    </div>
    
        <ul>
        <li><?php echo __('Save your favorite orders'); ?></li>
        <li><?php echo __('Save time and order from your history'); ?></li>
        <li><?php echo __('Save multiple delivery addresses'); ?></li>
        <li><?php echo __('Create a profile and receive personalize offers'); ?></li>
    </ul>
</div>