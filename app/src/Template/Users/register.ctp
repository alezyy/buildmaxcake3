<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        
    </ul>
</div>
<div class="users form col-lg-10 col-md-9 columns">
    <?= $this->Form->create(($user), ['class' => 'register col-xs-12 col-md-6 panel panel-default', 'id' => 'registerForm'] ); ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>

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


        <div class="form-group col-xs-12 col-md-6">
            <?php echo $this->Form->input('email'); ?>
        </div>
        
         <div class="form-group col-xs-12 col-md-7">
        <?php echo $this->Form->input('password', array(
        'class' => 'form-control',
        'autocomplete' => 'on',
        'required' => 'required',
        'placeholder' => __('Password'),
        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
             )); ?>
        </div>
        <div class="form-group col-xs-12 col-md-7">
        <?php echo $this->Form->input('password_confirm', array(
                    'placeholder'  => __('Confirm Password'),
                    'type'         => 'password',
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                    'equalto' => 'password',
                    'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                )); ?>
        </div>
        <div class="form-group col-xs-12 col-md-6">
             <?php echo $this->Form->input('group_id', ['options' => $groups]); ?>
        </div>
    
     

    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
    <?= $this->Form->end() ?>
</div>
