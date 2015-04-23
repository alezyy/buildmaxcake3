<?php
$this->Html->addCrumb(__('Locations'), array(
    'controller' => 'locations',
    'action'     => 'index'
));
$this->Html->addCrumb(__('Add Location'));
?>
<div class="locations form span8">
    <h2><?php echo __('New Restaurant'); ?></h2>
    <?php echo $this->Form->create('Location', array('type' => 'file')); ?>
    
      <fieldset>
        <legend><?php echo __('Information'); ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('name_fr');
        echo $this->Form->input('name_en');
        echo $this->Form->input('status', array('options' => array('active' => __('Active'), 'inactive' => __('Inactive'))));
        echo $this->Form->input('owner_name');
        echo $this->Form->input('email');
        echo $this->Image->input('logo');
        echo $this->PDF->input('pdf_menu');
        ?>
        <legend><?php echo __('Address'); ?></legend>
        <?php
        echo $this->Form->input('building_number');
        echo $this->Form->input('street');
        echo $this->Form->input('city', array('value' => 'Montreal'));
        echo $this->Form->input('postal_code');
        echo $this->Form->input('country', array('type' => 'hidden', 'value' => 'QUEBEC'));
        echo $this->Form->input('country', array('type' => 'hidden', 'value' => 'CA'));
        echo $this->Form->input('phone');
        echo $this->Form->input('phone2');
        ?>

        <legend><?php echo __('Description'); ?></legend>
        
        <?php echo $this->Form->input('sector_slug', array('list' => 'sector_slugs_list')); ?>
        <datalist id="sector_slugs_list">
            <?php foreach ($sectors as $key => $value) : ?>
                <option value="<?php echo $value ?>"</option>
            <?php endforeach; ?>
        </datalist>
        
        <?php
        echo $this->Form->input('description_en');
        echo $this->Form->input('description_fr');
        echo $this->Form->input('Cuisine', array('style' => 'height: 300px;'));
        ?>

        <legend><?php echo __('Online Ordering'); ?></legend>
        <?php
        echo $this->Form->input('contract_number');
        echo $this->Form->input('delivery', array('type' => 'checkbox'));
        echo $this->Form->input('pickup', array('type' => 'checkbox'));
        echo $this->Form->input('online_ordering', array('type' => 'checkbox'));
        echo $this->Form->input('delivery_min_order');
        echo $this->Form->input('delivery_average_time', array('placeholder' => 'minutes'));
        echo $this->Form->input('language', array('type' => 'hidden', 'value' => 'fr'));
        echo $this->Form->input('delivery_commission');
        echo $this->Form->input('pickup_commission');
        echo $this->Form->input('id');
        $this->Form->unlockField('logo');
        ?>
    </fieldset>   
    <?php echo $this->Form->end(__('Submit')); ?>

    <h3><?php echo __('Sectors postal codes'); ?></h3>
    <?php echo $this->Html->link(__('Add sector'), array('controller' => 'sectors', 'action' => 'add')); ?>
    <ul>
        <?php foreach ($sectors AS $k => $s): ?>
            <li><?php echo $s; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
