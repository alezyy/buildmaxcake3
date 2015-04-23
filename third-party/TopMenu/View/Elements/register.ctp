<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round" data-pack="default" data-tags="delete, trash, kill, x" style="display: inline-block;"></i></button>
                    <h4 class="modal-title" id="myModalLabel"><strong><?php echo __('Register'); ?></strong></h4>
                </div>
                <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'register center block', 'action' => 'register', 'id' => 'registerForm')); ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('Profile.first_name', array(
                            'type' => 'text',
                            'class' => 'form-control',
                            'autocomplete' => 'on',
                            'required' => 'required',
                            'placeholder' => __('First Name'),
                            'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                        )); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('Profile.last_name', array(
                            'type' => 'text',
                            'class' => 'form-control',
                            'autocomplete' => 'on',
                            'required' => 'required',
                            'placeholder' => __('Last Name'),
                            'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                        )); ?>
                    </div>
                     <div class="form-group">
                        <?php echo $this->Form->input('User.email', array(
                            'type' => 'email',
                            'class' => 'form-control',
                            'autocomplete' => 'on',
                            'required' => 'required',
                            'placeholder' => __('Email Address'),
                            'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                        )); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('User.password', array(
                            'class' => 'form-control',
                            'autocomplete' => 'on',
                            'required' => 'required',
                            'placeholder' => __('Password'),
                            'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                        )); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('User.password_confirm', array(
                                        'placeholder'  => __('Confirm Password'),
                                        'type'         => 'password',
                                        'autocomplete' => 'on',
                                        'class' => 'form-control',
                                        'equalto' => 'UserPassword',
                                        'error' => array('attributes' => array('wrap' => 'small', 'class' => 'has-error'))
                                    )); ?>
                    </div>
                    <div class="form-group">
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
                <div class="modal-footer">
                    <?php echo $this->Form->submit(__('Sign Up!'), array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'registerFormSubmit')); ?>
                </div>
                 <?php echo $this->Form->End(); ?>
                
                                
      </div>
    </div>
</div>