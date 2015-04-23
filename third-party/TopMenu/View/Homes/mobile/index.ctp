<?php
$commonKeywords = __('Delivery, Topmenu, Restaurants, Order, Montreal');
$metaDescriptionString = __("Topmenu provides online food delivery and pickup from restaurants in Montreal.");
$this->set('meta_keywords', "<meta name='keywords' content='$commonKeywords' />\n");
$this->set('meta_description', "<meta name='description' content='$metaDescriptionString' />\n");
$this->set('meta_city', "<meta name='city' content='Montreal' />\n");
$this->set('meta_state', "<meta name='state' content='Quebec' />\n");
echo $this->element('please_wait');
?>

<div id="mobile-inner_content">

    <div>
        <div class="home_row">
            <?php echo $this->Html->image('mobile/topmenu_logo_title.png', array('style' => 'width: 70%;')); ?>
        </div>

        <!-- DELIVERY -->    
        <div class="home_row">
            <?php echo $this->Html->image('mobile/home_sushi.png'); ?>
        </div>
        <div class="home_row" style="margin-top: 20px">

            <?php
            echo $this->Form->create('Location', array(
                'class' => 'form-inline',
                'url' => array(
                    'controller' => 'locations',
                    'action' => 'search',
                    '#' => 'search_delivery'),
                'id' => 'delivery'));

            echo $this->Form->input('type', array(
                'type' => 'hidden',
                'value' => 'delivery'));
            ?>
            <div class="control-group">
                <div class="input-append" style="width: 100%;">
                    <?php
                    echo $this->Form->input('postal_code1', array(
                        'label' => FALSE,
                        'class' => 'shadow_txtBox span1 postal_code1 postal_code',
                        'maxlength' => 3,
                        'style' => 'text-transform: uppercase;',
                        'autocomplete' => 'off',
                        'placeholder' => 'H0H',
                        'append' => 'append',
                        'div' => FALSE,
                        'no_div' => TRUE,
                        'tabindex' => 1));
                    echo $this->Form->button(
                        $this->Html->image('mobile/geo.png'), array(
                        'append' => 'append',
                        'div' => FALSE,
                        'id' => 'geolocate_me',
                        'type' => 'button',
                        'no_div' => TRUE,
                        'tabindex' => 2));
                    echo $this->Form->button(
                        $this->Html->image('mobile/search_icon.png'), array(
                        'append' => 'append',
                        'id' => 'submit_home',
                        'div' => FALSE,
                        'no_div' => TRUE,
                        'tabindex' => 2));
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>        
    </div>			
</div>


<input type="hidden" id="isTablet" value="<?php echo $is_tablet ?>"/>
<input type="hidden" id="isMobile" value="<?php // echo $is_mobile ?>"/>
<script>
    // google event for the geo button
    $('#geolocate_me').on('click', function() { ga('send', 'event', 'link', 'geo-button', 'geo-button');  });
</script>
<?php  echo $this->Html->script('search_box');
