<?php
$i         = 0;  // display "Required choice" title only once
$j         = 0;  // has not required options?$i
$k         = 0;  // display "Extras" title only once"
$l         = 0;  // number of instances
$m         = 0;  // count any MenuItemOption
$hasExtras = FALSE;
?>


      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id=""><b><?php echo $itemOptions['MenuItem']['name'] ?></b></h4>
      </div>
      <?php echo $this->Form->create(
            'MenuItem', array(
            'url' => array(
                'controller' => 'menuItems',
                'action'     => 'add_to_order'
            ),
            'id'  => 'modalForm')); ?>
            
      <div class="modal-body col-xs-12">
        <input type="hidden" id="itemPrice" value="<?php echo $itemOptions['MenuItem']['price'] ?>"/>
        <?php if (!empty($itemOptions['MenuItem']['description'])): ?>
        <div class="col-xs-12">
            <?php echo $itemOptions['MenuItem']['description']; ?>
        </div>
        <?php endif; 

        
            echo $this->Form->hidden('MenuItem.id', array('value' => $itemOptions['MenuItem']['id']));
            echo $this->Form->hidden('MenuItem.price', array('value' => $itemOptions['MenuItem']['price']));
            echo $this->Form->hidden('MenuItem.name', array('value' => $itemOptions['MenuItem']['name']));
            echo $this->Form->hidden('MenuItem.description', array('value' => $itemOptions['MenuItem']['description']));
            echo $this->Form->hidden('MenuItem.number_of_instance', array('value' => $itemOptions['MenuItem']['number_of_instance']));
        ?>
            <!-- Hidden input for currency -->
            <input type="hidden" id="user_i18n" value="<?php echo $langSuffix. '_' . Configure::read('I18N.COUNTRY_CODE_2') ?>"/>


            <?php if ($itemOptions['MenuItem']['number_of_instance'] > 1) : ?>
                <div class="col-xs-12 space">
                    <?php echo $this->Form->checkbox("MenuItem.duplicate", array('id' => 'duplicateChoices', 'checked' => '')); ?>
                    <?php echo __('Same options for all portions? '); ?>
                </div>
            <?php endif; ?> 

            <!-- REQUIRED CHOICES -->
            <?php
        ?>
            <div class="col-xs-12">
            <?php foreach ($itemOptions['MenuItemOption'] as $mio) {
                $m++;
                if (!empty($mio['MenuItemOptionValue'])) {
                    if ($hasRequired) {
                        if ($i++ === 0) {
                            ?>
                            <div class="page-header">
                                
                                <h4><b><?php echo __('Required choices'); ?></b></h4>
                            </div>
                        <?php } ?>
                        <div>
                            <?php
                            // filter out not required options                          
                            if ($mio['required'] === TRUE) {

                                // duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
                                if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
                                    $nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
                                } else {
                                    $nbOfColumns = 1;
                                }
                                for ($l = 0; $l < $nbOfColumns; $l++) {
                                    $half      = $l;   // input index when there is two part to the item 
                                    $duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
                                    $required  = ($l > 0) ? '' : array('required' => 'required'); // do not set the duplicate optin has to required to avoid javascript exception: "An invalid form control with name='data[MenuItemOptionValues][Required][Price][1][Entities][1]' is not focusable."
                                    ?>
                                                
                                        <?php
                                        if ($mio['number_of_free_values'] > 0) { // Chose more than one option value for one option
                                            // build array for select box without prices
                                            $selectOptions1 = array();
                                            foreach ($mio['MenuItemOptionValue'] as $miov) :
                                                $selectOptions1[] = array(
                                                    'name'      => $miov['name'],
                                                    'nameonly'  => $miov['name'],
                                                    'niceprice' => $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                    'value'     => $miov['id'],
                                                    'price'     => 0);
                                            endforeach; ?>

                                            <div class="col-xs-12 col-md-6">    
                                                <div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>                                          
                                                    <?php echo __('%s - (%d Free)', array($mio['name'], $mio['number_of_free_values'])); ?>
                                                </div>

                                                <?php
                                                for ($index = 0; $index < $mio['number_of_free_values']; $index++) :
                                                    ?>
                                                    <div class="control-group">
                                                        <?php
                                                        // display has many select box as the amount of free item options                               
                                                        echo $this->Form->select(
                                                            "MenuItemOptionValues.Required.Free.{$m}.Entities.{$l}.{$index}", $selectOptions1, array(
                                                            'empty'     => __('-- Select One --'),
                                                            'class'     => 'form-control required',
                                                            $required,
                                                            'duplicate' => $duplicate));
                                                        ?>
                                                        <div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
                                                    </div>
                                                    <br/>
                                                    <?php
                                                endfor; ?>
                                            </div>


                                            <?php $selectBox = array(); // clear array
                                        } else {
                                            ?>

                                            <div class="option-modal-label" duplicate='<?php echo $duplicate; ?>' >
                                                <?php echo __($mio['name']); ?>
                                            </div>

                                            <?php
                                            // build array for select box with prices
                                            $selectOptions2 = array();
                                            foreach ($mio['MenuItemOptionValue'] as $miov) :

                                                $selectOptions2[] = array(
                                                    'name'      => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                    'nameonly'  => $miov['name'],
                                                    'niceprice' => $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                    'value'     => $miov['id'],
                                                    'price'     => $miov['price']);
                                            endforeach;

                                            // options 
                                            if ($mio['multiselect'] === FALSE) :
                                                ?>

                                                <div class="control-group">
                                                    <?php
                                                    echo $this->Form->select(
                                                        "MenuItemOptionValues.Required.Price.{$m}.Entities.{$l}", $selectOptions2, array(
                                                        'empty'     => __('-- Select One --'),
                                                        'duplicate' => $duplicate,
                                                        'class'     => 'form-control required',
                                                        $required,
                                                        'id'        => $miov['id']));
                                                    $selectOptions2 = array(); // clear array
                                                    ?>
                                                    <div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
                                                </div>
                                            <?php
                                            // extras
                                            else :

                                                // build array for select box with prices
                                                foreach ($mio['MenuItemOptionValue'] as $miov) :

                                                    $selectOptions3[] = array(
                                                        'name'      => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                        'nameonly'  => $miov['name'],
                                                        'niceprice' => $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                        'value'     => $miov['id'],
                                                        'price'     => $miov['price']);
                                                endforeach;
                                                ?>
                                                <!-- //DEBUG 9.43 -->
                                                <div class="control-group">
                                                    <div class="input-append">
                                                        <?php
                                                        echo $this->Form->select(
                                                            '', $selectOptions3, array(
                                                            'empty'     => __('Select One then press -->'),
                                                            'duplicate' => $duplicate,
                                                            'inputId'   => $m,
                                                            'append'    => 'append',
                                                            'class'     => 'form-control required',
                                                            $required,
                                                            'id'        => $mio['id']));

                                                        echo $this->Form->button(
                                                            __('+'), array(
                                                            'class'     => 'btn btn-success addOption',
                                                            'type'      => 'button',
                                                            'duplicate' => $duplicate,
                                                            'append'    => 'append',
                                                            'id'        => 'btn_' . $mio['id']));
                                                        $selectOptions3 = array(); // clear array
                                                        ?>
                                                        <div class="help-inline" style="display: none"><?php echo __('Please select an option'); ?></div>
                                                    </div>
                                                </div>                                      
                                            <?php endif; ?>
                                           
                                    <?php } ?>      
                                <?php } ?>      <!-- //DEBUG 9.53 -->               
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>


            <!-- Extras -->
            <?php
            foreach ($itemOptions['MenuItemOption'] as $mio) {
                $m++;
                if (!empty($mio['MenuItemOptionValue'])) {
                    if ($mio['required'] === FALSE) {
                        if ($k++ == 0) {
                            ?>
                            <div>
                                <th colspan='<?php echo $itemOptions['MenuItem']['number_of_instance']; ?>' >
                            <h4 ><?php echo __('Extras'); ?></h4>
                            </th>
                            </div>
                        <?php } ?>
                        <div>
                            <?php
                            // duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
                            if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
                                $nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
                            } else {
                                $nbOfColumns = 1;
                            }

                            for ($l = 0; $l < $nbOfColumns; $l++) {
                                $half      = $l;   // input index when there is two part to the item 
                                $duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
                                ?>
                                            
                                    <?php
                                    // Free items
                                    if ($mio['number_of_free_values'] > 0) {

                                        // build array for select box without prices
                                        foreach ($mio['MenuItemOptionValue'] as $miov) {
                                            $selectBox[] = array(
                                                'name'      => $miov['name'],
                                                'nameonly'  => $miov['name'],
                                                'niceprice' => $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                                'value'     => $miov['id'],
                                                'price'     => 0,
                                            );
                                        }
                                        ?>
                                        <div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>
                                            <?php echo __('%s - (%d Free)', array($mio['name'], $mio['number_of_free_values'])); ?>
                                        </div>
                                        <?php
                                        for ($index = 0; $index < $mio['number_of_free_values']; $index++) {
                                            // display has many select box as the amount of free item options                               
                                            echo $this->Form->select(
                                                "MenuItemOptionValues.NotRequired.Free.{$m}.Entities.{$l}.{$index}", $selectBox, array(
                                                'empty'     => __('-- Select One --'),
                                                'duplicate' => $duplicate,
                                                'class'     => 'form-control required'));
                                            echo "<br/>";
                                        }
                                        $selectBox = array(); // clear array
                                    }
                                    ?>
                                
                            <?php } ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>


            <!-- Priced Extras -->
            <?php
            foreach ($itemOptions['MenuItemOption'] as $mio) {
                if (!empty($mio['MenuItemOptionValue'])) {

                    if (!$mio['required'] && $mio['number_of_free_values'] == 0) {
                        if ($k++ == 0) {
                            $hasExtras = TRUE;
                            ?>
                            <div>
                                <th colspan='<?php echo $itemOptions['MenuItem']['number_of_instance']; ?>' >
                            <h4 ><?php echo __('Extras'); ?></h4>
                            </th>
                            </div>
                        <?php } ?>
                        <div>
                            <?php
                            // duplicate the form columns to allow user to customize fraction of the item (ex.: 2 for 1 pizza with different toppings for each pizza)
                            if ($itemOptions['MenuItem']['number_of_instance'] > 1 && $mio['half_and_half'] == true) {
                                $nbOfColumns = $itemOptions['MenuItem']['number_of_instance'];
                            } else {
                                $nbOfColumns = 1;
                            }

                            for ($l = 0; $l < $nbOfColumns; $l++) {
                                $half      = $l;   // input index when there is two part to the item 
                                $duplicate = ($l > 0) ? 'true' : 'false';  // to hide/unhide the second column of input when the duplicate checkbox is togled
                                ?>
                                                    

                                    <div class="option-modal-label" duplicate='<?php echo $duplicate; ?>'>
                                        <?php echo __($mio['name']); ?>
                                    </div>

                                    <?php
                                    // build array for select box with prices
                                    foreach ($mio['MenuItemOptionValue'] as $miov) {
                                        $selectOptions[] = array(
                                            'name'      => $miov['name'] . ' —  ' . $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                            'nameonly'  => $miov['name'],
                                            'niceprice' => $this->Number->currency($miov['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')),
                                            'value'     => $miov['id'],
                                            'price'     => $miov['price']);
                                    }
                                    ?>

                                    <div class="input-append">
                                        <?php
                                        echo $this->Form->select(
                                            "MenuItemOptionValues.NotRequired.Price.{$m}.Entities.{$l}", $selectOptions, array(
                                            'empty'     => __('Select One then press -->'),
                                            'class'     => 'form-control extras_price',
                                            'duplicate' => $duplicate,
                                            'append'    => 'append',
                                            'half'      => $l,
                                            'name'      => FALSE,
                                            'id'        => $mio['id'] . '-' . $l));
                                        echo $this->Form->button(__('+'), array(
                                            'class'     => 'btn btn-success addOption',
                                            'half'      => $l,
                                            'append'    => 'append',
                                            'duplicate' => $duplicate,
                                            'type'      => 'button',
                                            'id'        => 'btn_' . $mio['id'] . '-' . $l,));
                                        $selectOptions = array();
                                        ?>
                                    </div>                                      
                                
                            <?php } ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>


            <?php for ($l = 0; $l < $itemOptions['MenuItem']['number_of_instance']; $l++) : ?>
                <div id="extraList-<?php echo $l; ?>"> 
                    <div id="extrasTotalPrice-<?php echo $l; ?>" >                                
                    </div>
                </div>
            <?php endfor ?>
        </div>    

                                                  
                                                 
                



                <!-- Subtotal -->
                <?php if ($hasExtras === FALSE) { ?>

                    <div class="option-modal-label-total" id="extrasTotalPriceTd" style="visibility: hidden">
                        <?php echo $this->Number->currency(0, $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                    </div>
                <?php } else { ?>

                    <div>
                        <div class="right" style="width: 100%;">
                            <div class="option-modal-label-total">                                                                  
                                <?php echo __('Extras total: ') ?>
                            </div>
                        </div>
                        
                        <div class="total">
                            <div class="option-modal-label-total" id="extrasTotalPriceTd">                                                                  
                                <?php echo $this->Number->currency(0, $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                            </div>
                        </div>
                        
                    </div>
                <?php } ?>
                <!-- Quantity -->
                <div class="col-xs-12">
                    
                        <div class="col-xs-10 row" id="extrasTotalPriceTd">                                                                  
                            <h4><b><?php echo __('Quantity ') ?></b></h4>
                        </div>
                    
                    

                                                                                          
                            <?php
                            echo $this->Form->input('qty', array(
                                'class'    => 'qty-spinner pull-right col-xs-2',
                                'label'    => FALSE,
                                'type'     => 'text',
                                'div'      => FALSE,
                                'no_div'   => TRUE,
                                'readonly' => 'readonly',
                                'id'       => 'qty',
                                'value'    => 1
                            ));
                            ?>
                        
                    
                </div>               

                <!-- Grand Total-->

                <div class="col-xs-12">
                    <div class="option-modal-label-total pull-left">                                                                  
                        <h2><b><?php echo __('Grand Total ') ?></b></h2>
                    </div>
                    <div class="option-modal-label-total pull-right">                                                                  
                        <h2 id="grandTotal"><?php echo $this->Number->currency($itemOptions['MenuItem']['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?></h2>
                    </div>
                </div>
                <br/>
                <br/>
                <!-- Comment -->
                <div class="col-xs-12">
                    <?php echo __('Leave a comment to the restaurant about this item: '); ?>
                    <?php echo $this->Form->textarea('comment', array('class' => 'form-control')); ?>
                </div>

         
      </div>
      <div class="modal-footer">
        <?php 
            echo $this->Form->button(__('Cancel'), array(
                'class'        => 'btn btn-default',
                'data-dismiss' => 'modal',
                'type'         => 'button'));
           

            echo $this->Form->button(__('ADD'), array(
                'class'            => 'btn btn-primary ajax_cart',
                'type'            => 'submit',
                'id'               => ($isAcceptingOrders === 'disabled') ? 'nullId' : 'submitBtn', // If restaurant is close this prevents javascript from enabling the button 
                $isAcceptingOrders => $isAcceptingOrders));
            ?>
      </div>
      <?php echo $this->Form->End(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(".qty-spinner").TouchSpin({
            min: 1,
            verticalbuttons: true
    });
</script>

<?php echo $this->Html->script('options_modal_form'); ?>
<?php echo $this->Html->script('options_modal_form_inner'); ?>