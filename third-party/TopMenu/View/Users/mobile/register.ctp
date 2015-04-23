<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Session->flash(); ?>    

<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Sign Up'); ?>
    </div>
</div>

<?php echo $this->Form->create('User'); ?>
<div class="row_mobile row mobile_default_form">
    <div class="form_input_label">
        <label for="ProfileFirstName"><?php echo __('First Name:'); ?><sup class="red">*</sup></label>
    </div>
    <?php echo $this->Form->input('Profile.first_name', array('label' => false, 'div' => false, 'no_div' => true, 'required' => 'required')); ?>

    <div class="form_input_label">
        <label for="ProfileLastName"><?php echo __('Last Name:'); ?><sup class="red">*</sup></label>
    </div>
    <?php echo $this->Form->input('Profile.last_name', array('label' => false, 'div' => false, 'no_div' => true, 'required' => 'required')); ?>

    <div class="form_input_label">
        <label for="UserEmail"><?php echo __('Email:'); ?><sup class="red">*</sup></label>
    </div>
    <?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'no_div' => true, 'type' => 'email', 'required' => 'required')); ?>

    <div class="form_input_label">
        <label for="UserPassword"><?php echo __('Password:'); ?><sup class="red">*</sup></label>
    </div>
    <?php echo $this->Form->input('User.password', array('label' => false, 'div' => false, 'no_div' => true, 'type' => 'password', 'required' => 'required')); ?>

    <div class="form_input_label">
        <label for="UserPassword"><?php echo __('Confirm Password:'); ?><sup class="red">*</sup></label>
    </div>
    <?php echo $this->Form->input('User.password_confirm', array('label' => false, 'div' => false, 'no_div' => true, 'type' => 'password', 'required' => 'required', 'autocomplete' => 'off')); ?>

    <?php
    echo $this->Form->input('Profile.phone', array('type' => 'hidden', 'value' => 'default'));
    echo $this->Form->hidden('Profile.timezone', array('value' => 'America/Montreal'));
    ?>
</div>

<div class="row row_emphasis">
    <?php
    echo $this->Form->end(array(
        'label' => __('Sign Up!'),
        'div' => false, 'no_div' => true,
        'no_div' => true,
        'class' => 'btn btn-success',
    ));
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



<?php
echo $this->element('password_meter');
echo $this->Html->script('password_meter', array('inline' => false));
echo $this->Html->script('provinces', array('inline' => false));
echo $this->Html->script('register');
