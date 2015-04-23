
<div id="content_inner">
    <div class="other_center">
        <div class="gray_head_box">
            <div class="gray_head_heading">
                <h1><?php echo __('Edit your profile') ?></h1>
            </div>
        </div>
        <div class="location_view">

            <fieldset>
                <?php echo $this->Form->create('Profile', array('type' => 'file')); ?>

                <?php echo $this->Image->input('image'); ?>
                <?php echo $this->Form->input('Profile.first_name'); ?>
                <?php
                echo $this->Form->input('Profile.last_name');
                echo $this->Form->input(
                    'Profile.gender', array(
                    'options' => array(
                        'empty'  => __('Select a Gender'),
                        'male'   => __('Male'),
                        'female' => __('Female')
                    )
                    )
                );
                echo $this->Form->input(
                    'date_of_birth', array(
                    'minYear' => date('Y') - 100,
                    'maxYear' => date('Y'),
                    )
                );

                echo $this->Form->input('Profile.phone');

                echo $this->Form->input(
                    'Profile.language', array(
                    'options' => array(
                        'en' => 'English',
                        'fr' => 'Français'
                    )
                    )
                );

                echo $this->Form->input('User.email');

                echo $this->Form->input(
                    'User.password', array(
                    'label'        => __('Change Password?'),
                    'autocomplete' => 'off',
                    'value'        => '',
                    'placeholder'  => __('Leave empty to keep password')));

                echo $this->Form->input(
                    'User.password_confirm', array(
                    'label'        => __('Confirm Password'),
                    'type'         => 'password',
                    'value'        => '',
                    'autocomplete' => 'off'
                ));


                echo $this->Form->end(array(
                    'class' => 'btn btn-danger pull-right',
                    'label' => __('Save')));
                ?>
            </fieldset>

            <div>
                <?php
                echo $this->Html->link(__("My Profile"), array(
                    'controller' => 'users',
                    'action'     => 'my_account'), array('class' => 'edit'));
                ?>
                &nbsp;|&nbsp;

                <?php
                echo $this->Html->link(
                    __("View Delivery Addresses"), array('controller' => 'delivery_addresses'), array('class' => 'edit')
                );
                ?>
                &nbsp;|&nbsp;

                <?php
                echo $this->Html->link(__("Add delivery address"), array(
                    'controller' => 'delivery_addresses',
                    'action'     => 'user_add'), array('class' => 'edit')
                );
                ?>
            </div>                    
        </div>
    </div>
</div>
<?php
echo $this->element('password_meter');
echo $this->Html->script('password_meter', array('inline' => false));
echo $this->Html->script('provinces', array('inline' => false));
echo $this->Html->script('register');
