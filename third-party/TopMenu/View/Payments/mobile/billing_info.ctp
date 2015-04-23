
<?php
$this->assign('mobile_header_block', $this->element('mobile/checkout_header', array(
        'title' => __('Payment'),
        'alt'   => __('Back to order detail'),
        'href'  => Router::url(array('controller' => 'orders', 'action' => 'checkout')))));
?>

<!-- BILLING ADDRESS INFORMATION #(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(#(# -->

<div id="billing_address" class="row_mobile row">
    <p class="strong"><?php echo __('Billling Address'); ?></p>
    <div class="description" id="ba_info">
        <?php
        $address2    = $this->Session->read('BillingAddress.address2');
        $crossStreet = $this->Session->read('BillingAddress.cross_street');
        ?>
        <?php echo $this->Session->read('BillingAddress.phone') ?>, <br/>
        <?php echo $this->Session->read('BillingAddress.address') ?>, 
        <?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
        <?php echo $this->Session->read('BillingAddress.city') ?>
        (<?php echo $this->Session->read('BillingAddress.province') ?>)<br/>
        <?php echo $this->Session->read('BillingAddress.postal_code') ?><br/>
        <?php echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>'; ?>
    </div>
    <div id="ba_edit_button" class="edit_button-square">
        <?php
        echo $this->Html->link(
            $this->Html->image('BOUTONS/edit_button.png'), array('controller' => 'delivery_addresses', 'action' => 'confirm_billing_address', $this->Session->read('BillingAddress.id')), array('escape' => false));
        ?>
    </div>
</div>

<hr class="item" />


<!-- CREDIT CARD FORM *&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*& -->



<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Credit Card Informations'); ?>		
    </div>

    <div id="secure_payment_shield">
        <?php echo $this->Html->image('checkout/secure_payment_shield.png'); ?>
    </div>
</div>

<?php
echo $this->Form->create(
    'Payment', array(
    'url'          => array('controller' => 'orders', 'action' => 'proceed_to_payment'),
    'id'           => 'proceedToPaymentForm',
    'autocomplete' => 'off',
));
?>
<div class="row_mobile row mobile_default_form">
    <?php
    echo $this->Form->input('Payment.credit_card.first_name', array(
        'label'        => "First name on card <sup class='red'>*</sup>",
        'autocomplete' => 'on',
        'div'          => false,
        'no_div'       => true,
        'type'         => 'text',
        'required'     => 'required'));
    ?>

    <?php
    echo $this->Form->input('Payment.credit_card.last_name', array(
        'label'        => "Last name on card <sup class='red'>*</sup>",
        'autocomplete' => 'on',
        'div'          => false,
        'no_div'       => true,
        'type'         => 'text',
        'required'     => 'required'));
    ?>

    <?php
    echo $this->Form->input('Payment.credit_card.number', array(
        'div'          => false,
        'label'        => "Credit card number<sup class='red'>*</sup>",
        'autocomplete' => 'off',
        'no_div'       => true,
        'type'         => 'number',
        'required'     => 'required',
        'pattern'      => '([0-9] {0,1}){13,16}'));
    ?>

    <div class="help-inline" style="display: none;"><?php echo __('Invalid credit card number'); ?></div>

    <?php
    echo $this->Form->input('Payment.credit_card.expire_month', array(
        'div'      => false,
        'label'    => "Expire month <sup class='red'>*</sup>",
        'autocomplete' => 'off',
        'no_div'   => true,
        'required' => 'required',
        'options'  => array(
            '1'  => __('January') . ' (01)',
            '2'  => __('February') . ' (02)',
            '3'  => __('March') . ' (03)',
            '4'  => __('April') . ' (04)',
            '5'  => __('May') . ' (05)',
            '6'  => __('June') . ' (06)',
            '7'  => __('July') . ' (07)',
            '8'  => __('August') . ' (08)',
            '9'  => __('September') . ' (09)',
            '10' => __('October') . ' (10)',
            '11' => __('November') . ' (11)',
            '12' => __('December') . ' (12)')));
    ?>

    <?php
    echo $this->Form->input('Payment.credit_card.expire_year.year', array(
        'autocomplete' => 'off',
        'div'        => false,
        'no_div'     => true,
        'label'      => "Expire year<sup class='red'>*</sup>",
        'type'       => 'select',
        'dateFormat' => 'Y',
        'required'   => 'required',
        'empty'      => array(14 => 2014),
        'options'    => array(// This is ugly, but very slightly more performant
            15 => 2015, 16 => 2016, 17 => 2017, 18 => 2018, 19 => 2019, 20 => 2020, 21 => 2021, 22 => 2022,
            23 => 2023, 24 => 2024, 25 => 2025, 26 => 2026, 27 => 2027, 28 => 2028, 29 => 2029, 30 => 2030,
            31 => 2031, 32 => 2032, 33 => 2033, 34 => 2034, 35 => 2035, 36 => 2036, 37 => 2037, 38 => 2038,
            39 => 2039, 40 => 2040, 41 => 2041, 42 => 2042, 43 => 2043, 44 => 2044, 45 => 2045)));
    ?>

    <?php
    echo $this->Form->input('Payment.credit_card.cvv2', array(
        'autocomplete' => 'off',
        'div'      => false,
        'no_div'   => true,
        'type'     => 'number',
        'label'    => "CVV2 Number <sup class='red'>*</sup>&nbsp;&nbsp;&nbsp;" . $this->Html->image('checkout/cvv.png', array('height' => 30)),
        'required' => 'required'));
    echo $this->Form->input('Payment.credit_card.cvv3', array('type' => 'hidden'));

    $this->Html->image('checkout/cvv.png', array('height' => 30));
    ?>
</div>

<div class="fine_print_right">
    <?php echo __("Fields marked with %s are required", "<sup class='red'>*</sup>"); ?>
</div>

<div class="row_mobile row red" style="text-align: center; font-style: italic">
    <?php
    echo $this->Form->input('', array('type' => 'checkbox', 'id' => 'terms_checkbox', 'no_div' => true, 'div' => false, 'checked' => 'checked', 'label' => false));
    echo $this->Html->link(__("By selecting this check box I agree to Topmenu's Terms & Conditions"), array('controller' => 'pages', 'action' => 'terms'), array('style' => 'color: #E23D48; text-decoration: none;', 'target' => '_blank', 'escape' => false));
    ?>				
</div>


<!-- HIDDEN FIELDS -=-=-=-=-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->

<?php echo $this->Form->hidden('Payment.billing_address.phone', array('id' => 'pbal1', 'value' => $this->Session->read('Order.Order.phone'))) ?>
<?php echo $this->Form->hidden('Payment.billing_address.line1', array('id' => 'pbal1', 'value' => $this->Session->read('Order.Order.address'))) ?>
<?php echo $this->Form->hidden('Payment.billing_address.line2', array('id' => 'pbal2', 'value' => $this->Session->read('Order.Order.address2'))) ?>
<?php echo $this->Form->hidden('Payment.billing_address.city', array('id' => 'pbalc', 'value' => $this->Session->read('Order.Order.city'))) ?>
<?php echo $this->Form->hidden('Payment.billing_address.postal_code', array('id' => 'pbalpc', 'value' => $this->Session->read('Order.Order.postal_code'))) ?>
<?php echo $this->Form->hidden('Payment.billing_address.state', array('id' => 'pbalps', 'value' => $this->Session->read('Order.Order.province'))) ?>

<?php echo $this->Form->hidden('Payment.return_urls.cancel_url', array('value' => 'cancelURL')) ?>
<?php echo $this->Form->hidden('Payment.return_urls.return_url', array('value' => 'returnURL')) ?>

<div id="credit_card_form" class="row_mobile row">
    <?php
    echo $this->Form->input('Order.special_instruction', array(
        'id'     => 'OrderSpecialInstructionCredit',
        'div'    => false,
        'no_div' => true,
        'type'   => 'text'));
    ?>
</div>

<div class="row row_emphasis">
	<?php echo __('Please verify that your <strong>billing address</strong> is correct before proceeding. Thank you'); ?>
</div>

<div class="row row_emphasis">
    <?php
    echo $this->Form->submit(__('Place Order'), array(
        'name'  => 'method_of_payment_is_credit',
        'id'    => 'modalConfirmationPlaceOrder',
        'class' => 'btn btn-success'));
    ?>
</div>
<?php
echo $this->Form->end();

echo $this->Form->hidden('orderId', array('value' => $orderId, 'id' => 'orderId'));
if ($orderId):
    echo $this->Form->hidden('onBeforeUnloadMessage', array('value' => __('Leaving or reloading this page will delete your current order. Continue?'), 'id' => 'onBeforeUnloadMessage'));
endif;
?>


<!-- FOOTER %!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%!%! -->

<div class="mobile_footer_img">
    <?php echo $this->Html->image('checkout/secure_payment_shield.png'); ?>
    <?php echo $this->Html->image('checkout/Master_Card_Icon.png'); ?>
    <?php echo $this->Html->image('checkout/Visa_Payment_icon.png'); ?>
    <?php echo $this->Html->image('checkout/evo.png'); ?>
</div>
<div class="mobile_footer fine_print" style="margin-bottom: 14px; padding: 16px">
    <span class="strong"><?php echo __("Secure Payment Gateway:"); ?> </span>
    <?php echo __("All transactions are secured using SSL encryption using a GlobalSign certificate."); ?>
</div>


<!-- CASH FORM =+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+= -->

<?php
echo $this->Form->create(
    'Payment', array(
    'url' => array('controller' => 'orders', 'action' => 'proceed_to_payment'),
    'id'  => 'proceedToPaymentForm'));


// replicate the special instruction field Javascript will copy data into it from the other input on the page
echo $this->Form->input('Order.special_instruction', array(
    'id'     => 'OrderSpecialInstructionCash',
    'div'    => false,
    'no_div' => true,
    'type'   => 'hidden'
));
?>
<?php $couponCode = $this->Session->read('Order.Order.coupon_code'); ?>
<?php if ($this->Session->read('Order.Order.type') === 'delivery' && empty($couponCode)): ?>
    <div class="row row_emphasis">
        <?php
        echo $this->Form->submit(__('Pay with cash'), array(
            'name'  => 'method_of_payment_is_cash',
            'id'    => 'modalConfirmationPlaceOrderCash',
            'class' => 'btn btn-success',
            'style' => 'margin: 2%; width: 96%;'));
        ?>
    </div>
<?php elseif ($this->Session->read('Order.Order.type') === 'delivery'): ?>

    <div class="row row_emphasis">
        <?php echo __('Coupons are available for credit card orders only. If you continue your coupon will not be applied and will be available at your next order'); ?>
        <?php
        echo $this->Form->submit(__('Pay with cash'), array(
            'name'  => 'method_of_payment_is_cash',
            'id'    => 'modalConfirmationPlaceOrderCash',
            'class' => 'btn btn-success',
            'style' => 'margin: 2%; width: 96%;'));
        ?>
    </div>
<?php endif; ?>
<?php echo $this->Form->end(); ?>
<script>
    $('#OrderSpecialInstructionCredit').change(function() {
        $('#OrderSpecialInstructionCash').val($('#OrderSpecialInstructionCredit').val());
    });
</script>
<?php
echo $this->Html->script('please_wait');
echo $this->Html->script('checkout');
echo $this->Html->script('place_order_button');
echo $this->Js->writeBuffer();
