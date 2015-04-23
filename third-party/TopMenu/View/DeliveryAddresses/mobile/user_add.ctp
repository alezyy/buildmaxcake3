<div class="row_mobile row">
    <div class="strong" style="float: left; line-height: 30px;">
        <?php echo __('Add a Delivery Address'); ?>
    </div>
</div>


<?php
echo $this->Form->create('DeliveryAddress', array(
    'url' => array(
        'controller' => 'delivery_addresses',
        'action' => 'user_add',
        $successPage)));
?>
<div class="row_mobile row mobile_default_form">
    <?php
    echo $this->Form->input('name', array('div' => false, 'no_div' => true));
    echo $this->Form->input('phone', array('div' => false, 'no_div' => true, 'required' => 'required'));
    echo $this->Form->input('secondary_phone', array('div' => false, 'no_div' => true));
    echo $this->Form->input('address', array('div' => false, 'no_div' => true, 'required' => 'required'));
    echo $this->Form->input('address2', array('div' => false, 'no_div' => true));
    echo $this->Form->input('city', array('div' => false, 'no_div' => true, 'required' => 'required'));

    echo $this->Form->input(
        'DeliveryAddress.province', array(
        'empty' => __('Select a Province'),
        'type' => 'select',
        'div' => false,
        'no_div' => true,
        'id' => 'provinces',
        'class' => 'shadow_txtBox w_210',
        'selected' => 'Quebec'));

    echo $this->Form->input(
        'DeliveryAddress.country', array(
        'empty' => __('Select a Country'),
        'type' => 'select',
        'id' => 'country',
        'div' => false,
        'no_div' => true,
        'class' => 'shadow_txtBox w_210',
        'selected' => Configure::read('I18N.COUNTRY_CODE_2')));

    echo $this->Form->input('postal_code', array('div' => false, 'no_div' => true, 'required' => 'required'));
    echo $this->Form->input('cross_street', array('div' => false, 'no_div' => true));
    ?>
</div>

<div class="row row_emphasis">

<?php
if (!empty($successPage)) {
    echo $this->Form->hidden('success_page', array('value' => $successPage));
}
?>

    <?php
    echo $this->Form->end(
        array(
            'class' => 'btn btn-success',
            'label' => __('OK')));
    ?>

</div>
