<div class="other_center">
    <div class="gray_head_box">
        <div class="gray_head_heading">
            <h1><?php echo __('You did not reaceive your paper Topmenu'); ?></h1>
        </div>
    </div>
    <div class="location_view">

        <h2><?php echo __('Please fill this form'); ?></h2>

        <?php
        echo $this->Form->create(NULL, array('url' => array(
                'controller' => 'contacts',
                'action'     => 'did_not_receive_print'
        )));
        ?>

        <fieldset>
            <legend><?php echo __('Your information'); ?></legend>
            <?php
            echo $this->Form->input('first_name', array('size' => 80,));
            echo $this->Form->input('last_name', array('size' => 80,));
            echo $this->Form->input('email', array('size' => 80));
            echo $this->Form->input('phone', array('label' => __('Phone'), 'size' => 80));
            echo $this->Form->input('phone', array('size' => 80));
            echo $this->Form->input(__('type'), array(
                'options' => array(
                    __('client')     => __('Client'),
                    __('restaurant') => __('Restaurant owner')),
                'label'   => __('Client/Restaurant')));
            echo $this->Form->input('postal_code', array(
                'label'    => __('Your postal code'),
                'size'     => 80,
                'required' => 'required',
                'pattern'  => '[a-zA-Z][0-9][a-zA-Z] {0,1}[0-9][a-zA-Z][0-9]'));
            echo $this->Form->input('wrong_postal_code', array(
                'label'   => __('Wrong menu? Which one did you get.'),
                'title'   => __('(Enter the sector name at the bottom of the front page)'),
                'size'    => 80,
                'pattern' => '[a-zA-Z][0-9][a-zA-Z] {0,1}[0-9][a-zA-Z][0-9]'));
            echo $this->Form->input('comment', array(
                'label' => __('Leave a comment'),
                'type'  => 'textarea',
                'cols'  => 60,
                'rows'  => 5));
            ?>
        </fieldset>

        <?php
        echo $this->Form->input(__('Send'), array(
            'type'  => 'submit',
            'label' => FALSE,
            'class' => 'btn btn-success pull-right'));
        ?>
<?php echo $this->Form->end(); ?>
    </div>
</div>