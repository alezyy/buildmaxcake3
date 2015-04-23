<?php // Change the header  ?> 
<?php
$this->assign('mobile_header_block', $this->element('mobile/checkout_header', array(
        'title' => __('Your Order'),
        'alt'   => __('Back to menu page'),
        'href'  => $this->Session->read('Location.url'))));
?>

<!-- RESTAURANT INFORMATION -->
<?php echo $this->element('/mobile/restaurant_info_row', array('add_botom_border' => 'add_botom_border')); ?>

<!-- DELIVERY ADDRESS -->
<div class="row_mobile row row_emphasis add_botom_border">
    <p class="strong">
<?php echo ($this->Session->read('Order.Order.type') === 'delivery') ? __('Your order is for delivery to') : __('Your order is for takeout'); ?>
    </p>

        <?php if ($this->Session->read('Order.Order.type') === 'delivery'): ?>
        <p class="description">
            <?php
            $address2    = $this->Session->read('Order.Order.address2');
            $crossStreet = $this->Session->read('Order.Order.cross_street');
            ?>
            <?php echo $this->Session->read('Order.Order.address') ?>, 
            <?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
    <?php echo $this->Session->read('Order.Order.city') ?>
            (<?php echo $this->Session->read('Order.Order.province') ?>)
            &nbsp;<?php echo $this->Session->read('Order.Order.postal_code') ?><br/>
    <?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
        </p>
        <div class="left">

            <?php
            echo $this->Html->link(__('Take out'), array(
                'controller' => 'orders',
                'action'     => 'checkout',
                '?'          => array('type' => 'pickup')), array(
                'class' => 'edit_link green-text'));
            ?>
        </div>
        <div class="right">
            <?php
            echo $this->Html->link(__('Edit'), array(
                'controller' => 'delivery_addresses',
                'action'     => 'confirm',
                $this->Session->read('Order.Order.address_id')), array(
                'class' => 'edit_link green-text',
                $this->Session->read('Order.Order.address_id')));
            ?>
        </div>


        <?php
    else:
        echo $this->Html->link(__('Get it for delivery'), array(
            'controller' => 'orders',
            'action'     => 'checkout',
            '?'          => array('type' => 'delivery')), array(
            'class' => 'edit_link green right'));
    endif;
    ?>
</div>

<!-- ITEMS LIST -->
<?php $i         = 0; ?>
<?php $oodArray  = $this->Session->read('Order.OrderDetail'); ?>
<?php $oodlenght = count($this->Session->read('Order.OrderDetail')); ?>
<?php $odArray   = $this->Session->read('Order.OrderDetail'); ?>
<div class="last_item_red_border">	
    <?php foreach ($this->Session->read('Order.OrderDetail') as $key => $od): ?>		
                <!-- ITEM <?php echo $i++ ?> ------------------------------------------------ -->


        <div class="row_mobile row item">		

            <!-- COLLAPSABLE START -->			
            <div class="accordion-group">

                <!-- COLLAPSABLE HEADING -->								
                <div class="accordion-heading">	
                    <div class="left">
                        <?php echo $od['name'] ?>
                    </div>
                    <?php if (!empty($od['description']) || !empty($od['options'])): ?>
                        <div class="right" data-toggle="collapse" data-parent="#items_details" href="#item_<?php echo $i; ?>">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#items_details" href="#item_<?php echo $i; ?>">
                                <?php echo $this->Html->image('checkout/expand.png', array('alt' => 'details')); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- COLLAPSABLE BODY -->
                <div class="item_detail accordion-body collapse" id="item_<?php echo $i; ?>">
                    <p>
                        <?php echo $od['description'] ?>
                    </p>
                    <?php if (!empty($od['options'])) : ?>
                        <p>
                            <?php echo __('Options') ?>
                        </p>											
                        <table class="embedTable">
                            <?php foreach ($od['options'] as $o) : ?>
                                <tr>
                                    <td>
                                        <?php echo $o['quantity'] ?> X
                                    </td>
                                    <td>
                                        <?php echo $o['name'] ?>
                                    </td>														
                                    <td class="nowrap">
                                        <?php echo $this->Number->currency($o['price'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>


                </div>
            </div>
            <!-- END COLLAPSABLE -->


            <div class="bottom">
                <div class="left">
                    <?php
                    echo $this->Html->link(
                        $this->Html->image('checkout/minus-sign.png', array('alt' => __('add one'))), array("controller" => "orders", "action" => "decrement_item_quantity", $key), array('escape' => false, 'class' => 'decrement-item', 'rel' => 'nofollow', 'data-qty' => $od['quantity']));
                    ?>
                    <div class="item_price_calculation">
                        <?php echo $od['quantity']; ?> × <?php echo $this->Number->currency($od['subtotal'] / $od['quantity'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                    </div>
                    <?php
                    echo $this->Html->link(
                        $this->Html->image('checkout/plus-sign.png', array('alt' => __('add one'))), array("controller" => "orders", "action" => "increment_item_quantity", $key), array('escape' => false, 'class' => 'increment-item', 'rel' => 'nofollow'));
                    ?>

                </div>
                <div class="right">
                    <?php echo $this->Number->currency($od['subtotal'], $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                </div>
            </div>				
        </div>
        <hr class="item" />

    <?php endforeach; ?>			
</div>

<!-- TOTALS -->

<!-- Sub total -->	
<div class="last_item_red_border">	
    <div class="row_mobile row item">
        <div class="accordion-group">
            <div class="left strong">
                <?php echo __('Sub Total'); ?>
            </div>
            <div class="right strong">
                <?php echo $this->Number->currency($this->Session->read('Order.Order.subtotal'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
            </div>
        </div>
    </div>

    <!-- Coupon -->
        <hr class="item" />
        <div class="row_mobile row item">
            <div class="bottom"  style="float: left; line-height: 30px; width: 100%;">
                <div class="left strong" style="float: left;">
                    <?php echo __('Coupon'); ?>&nbsp;
                </div>

                <div class="right strong input-append" style="margin-bottom: 0;">


                    <?php
                    echo $this->Form->input('Order.coupon_code', array(
                        'id'     => 'couponCode',
                        'label'  => FALSE,
                        'append' => 'append',
                        'div'    => FALSE,
                        'no_div' => TRUE,
                        'style'  => 'max-width: 100px;',
                        'value'  => $this->Session->check('Order.Order.coupon_code') ? $this->Session->read('Order.Order.coupon_code') : "",
                        'title'  => __('Enter coupon code here and update your order')));
                    echo $this->Html->link(
                        __('Apply'), array("controller" => "orders", "action" => "apply_coupon"), array(
                        'class'  => 'btn btn-success addOption',
                        'rel'    => 'nofollow',
                        'escape' => false,
                        'id'     => 'apply_coupon',
                        'style'  => 'width: auto; text-decoration: none;',
                        'append' => 'append'));
                    ?>
                </div>
            </div>
            <?php if ($this->Session->read('Order.Order.coupon_discount') > 0): ?>
                <div class="bottom"  style="float: left; line-height: 30px; width: 100%;">
                    <div class="left " style="float: left;">
                        <?php echo __('Discount'); ?>
                    </div>
                    <div class="right strong red" style="margin-bottom: 0;">
                        <?php echo $this->Number->currency($this->Session->read('Order.Order.coupon_discount'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <hr class="item" />

    <!-- Delivery fee -->
    <div class="row_mobile row item">
        <div class="accordion-group">
            <div class="left strong">
                <?php echo __('Delivery Fee'); ?>
            </div>
            <div class="right strong">
                <?php echo $this->Number->currency($this->Session->read('Order.Order.delivery_charge'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
            </div>
        </div>		
    </div>
    <hr class="item" />

    <!-- GST -->
    <div class="row_mobile row item">
        <div class="accordion-group">
            <div class="left strong">
                <?php echo __('GST'); ?>
            </div>
            <div class="right strong">
                <?php echo $this->Number->currency($this->Session->read('Order.Order.gst'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
            </div>
        </div>		
    </div>
    <hr class="item" />

    <!-- PST -->
    <div class="row_mobile row item">
        <div class="accordion-group">
            <div class="left strong">
                <?php echo __('PST'); ?>
            </div>
            <div class="right strong">
                <?php echo $this->Number->currency($this->Session->read('Order.Order.pst'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
            </div>
        </div>		
    </div>
    <hr class="item" />

    <?php // Remove Tips for one restaraurant ?>
    <?php if ($location['Location']['id'] !== '528103ac-ddb8-43d3-a714-6a881ec880c8'): ?>
        <div class="row_mobile row item">		


            <!-- COLLAPSABLE START -->			
            <div class="accordion-group">

                <!-- COLLAPSABLE HEADING -->								
                <div class="accordion-heading">	
                    <div class="left">
                        <?php echo __('Tip'); ?>
                    </div>					
                </div>
            </div>
            <!-- END COLLAPSABLE -->


            <div class="bottom">
                <div class="left">
                    <?php
                    echo $this->Html->link(
                        $this->Html->image('checkout/minus-sign.png', array('alt' => __('add one'))), array("controller" => "orders", "action" => "decrement_tip", $key), array('escape' => false, 'class' => 'decrement-item', 'rel' => 'nofollow'));
                    ?>
                    <div class="item_price_calculation">
                        <?php echo $this->Number->currency($this->Session->read('Order.Order.tip'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                    </div>
                    <?php
                    echo $this->Html->link(
                        $this->Html->image('checkout/plus-sign.png', array('alt' => __('add one'))), array("controller" => "orders", "action" => "increment_tip", $key), array('escape' => false, 'class' => 'increment-item', 'rel' => 'nofollow'));
                    ?>

                </div>
            </div>				
        </div>
    <?php endif; ?>
    <hr class="item" />
</div>

<!-- Total -->
<div class="row_mobile row item">
    <div class="accordion-group">
        <div class="left strong">
            <?php echo __('Total'); ?>
        </div>
        <div class="right strong">
            <?php echo $this->Number->currency($this->Session->read('Order.Order.total'), $langSuffix . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
        </div>
    </div>		
</div>


<!-- SPECIFIC FOOTER TO THIS PAGE FOR ONE BUTTON -->

<div id="checkout-footer">

    <?php if ($allowPayment): ?>

        <div id="checkout-footer-button">
            <?php echo $this->Html->link(__('Place Order'), array('controller' => 'payments', 'action' => 'billing_info'), array('class' => 'btn btn-success', 'role' => 'button')); ?>
        </div>

    <?php endif; ?>	
</div>
<?php
echo $this->Html->script('mobilecheckout');
