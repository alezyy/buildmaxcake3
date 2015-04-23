
<?php echo $this->Form->create('DeliveryAddress', array('url' => array('action' => 'user_delete', $id, 'checkout'))); ?>
<fieldset>        
    <div class="btn-group">
        <?php echo $this->Form->button(__('no'), array('class' => 'btn btn-danger', 'div' => false, 'data-dismiss' => "modal", 'style'=>'width:100px')); ?>
        <?php echo $this->Form->submit(__('Yes'), array('class' => 'btn btn-success', 'div' => false, 'style'=>'width:100px')); ?>
    </div>
</fieldset>