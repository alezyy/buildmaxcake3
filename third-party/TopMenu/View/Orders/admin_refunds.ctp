<?php
$this->Html->addCrumb(__('Orders'), array(
    'controller' => 'orders',
    'action'     => 'index'
));
?>

<!-- Generate Report -->
<script>
    $('#content_home').css('width', '95%');
</script>
<style>
        .center_cell th{ text-align: center; background-color: #F9F9F9; border-right: 1px solid #DDDDDD  }
    .center_cell th.empty{ border: none; background: transparent; }
    .form_table td{padding: 7px; font-size: 13pt;}
    .order .form {width: 650px; margin:auto;}
    .orders table {width: 600px}
    .form-horizontal .controls{margin-left: 20px}
    .footer-other{display: none}
</style>

<div class="orders index">



    <fieldset>
        <legend><?php echo __('Refund An Order'); ?></legend>
        <div style="float:left; width:50%">
            <table class="form_table" >
                <tr>
                    <td><?php echo __('Order id:'); ?></td>
                    <td>
                        <div class="control-group" style="margin-left: 78px;">
                            <div class="controls number">
                                <input id="OrderOrder"/>    
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <?php echo $this->Form->create('Order'); ?>
            <?php echo $this->Form->input('id', array('id' => 'orderId')); ?>
            <table>                
                <tr>
                    <td><?php echo __('Amount to Refund:'); ?></td>
                    <td><?php
                        echo $this->Form->input('total', array('label' => false, 'type' => 'number', 'step' => "any", 'disabled' => 'disabled'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Refund reason:'); ?></td>
                    <td><?php
                        echo $this->Form->input('special_instructions', array('type' => 'textarea', 'label' => false));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td tiltle="<?php echo __('Transaction number givent by payment gateway'); ?>"><?php echo __('Refund Transaction id:'); ?></td>
                    <td><?php
                        echo $this->Form->input('transaction_id', array('label' => false, 'type' => 'text'));
                        ?>
                    </td>
                </tr>				
                <tr>
                    <td colspan="2" style="text-align: right">
                        <?php echo $this->Form->submit(); ?>
                    </td>
                </tr>
            </table>			
            <?php echo $this->form->end(); ?>
        </div>
        <div style="float: left; width: 48%;">
            <h4><?php echo __('Order'); ?></h4>
            <pre id="orderInfo">
                <!-- filled by ajax -->
            </pre>
            <h4><?php echo __('Order Details'); ?></h4>
            <pre id="orderDetails">
                <!-- filled by ajax -->
            </pre>
        </div>
    </fieldset>		

</div>

<script>
    $('#OrderOrder').keyup(function() {
        $('#orderId').val($(this).val());
        $('#OrderTotal').prop('disabled', true);
        if ($(this).val() !== '') {

            $.ajax({
                url: "/orders/getOrderTotal/" + $(this).val()
            }).done(function(data) {
                if (data) {
                    $('#OrderTotal').prop('disabled', false);
                    order = JSON.parse(data);
                    $('#OrderTotal').val((order.Order.total) * -1);   // insert refund total of order in the appropriate field 
                    $('#orderInfo').text(JSON.stringify(order.Order, "   ", 2));
                    $('#orderDetails').text(JSON.stringify(order.OrderDetail, "   ", 2));


                } else {
                    $('#OrderTotal').val('');
                }
            })
        } else {
            $('#OrderTotal').val('');
        }
    });
</script>

</div>