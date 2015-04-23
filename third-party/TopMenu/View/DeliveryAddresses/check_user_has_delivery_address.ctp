<?php if($show): ?>
    <?php if($reason === 'outside'): ?>
        <?php echo __('This restaurant does not deliver to this postal code: %s', $this->Session->read('DeliveryDestination.postal_code')); ?><br/>
    <?php endif; ?>
        <?php echo __('Please enter a new postal code in the input box or clause this window if you want to pickup the order.'); ?>
<?php else: ?>
        1
<?php endif;
