<div class="restaurants form span10">
<?php echo $this->Form->create('Restaurant'); ?>
    <fieldset>
        <legend><?php echo __('Add Restaurant'); ?></legend>
    <?php
        echo $this->Form->input('name', array('label' => __('Your name'), 'required' => 'required'));
        echo $this->Form->input('telephone', array('required' => 'required'));        
        echo $this->Form->input('email', array('required' => 'required'));                
        echo $this->Form->input('restaurant_name', array('required' => 'required'));
        echo $this->Form->input('restaurant_full_address', array('required' => 'required'));
        echo $this->Form->input('restaurant_food_type');
        echo $this->Form->input('delivery', array('label' => __('Delivery and/or take out ?')));
        echo $this->Form->input('language', array('options' => array('French' => __('French'), 'English' => __('English'))));
        echo $this->Form->input('message', array('type' => 'textarea'));        
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Send')); ?>
</div>
