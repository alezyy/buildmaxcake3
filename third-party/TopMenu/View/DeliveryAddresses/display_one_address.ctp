<?php if ($address['DeliveryAddress']['name'] && $displayLabel): ?>
	<span class="strong uppercase"><?php echo $address['DeliveryAddress']['name']; ?></span><br/>
<?php endif; ?>

<?php
$address2 = $address['DeliveryAddress']['address2'];
$crossStreet = $address['DeliveryAddress']['cross_street'];
?>
<?php echo $address['DeliveryAddress']['address'] ?>, 
<?php echo (empty($address2)) ? '' : $address2 . '<br/>'; ?>
<?php echo $address['DeliveryAddress']['city'] ?>&nbsp;
(<?php echo $address['DeliveryAddress']['province'] ?>)<br/>
<?php echo $address['DeliveryAddress']['postal_code'] ?><br/>
<?php
echo (empty($crossStreet)) ? '' : __('Intersection: ') . $crossStreet . '<br/>';
