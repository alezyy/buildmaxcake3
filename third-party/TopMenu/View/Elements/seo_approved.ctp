<?php
$distance = $this->Session->check('Location.distance') ? $this->Session->read('Location.distance') : '';
$distance = empty($distance) ? 'null' : number_format((float) $distance / 100, 1, '.', '');
$total = $this->Session->read('Order.Order.total');
$taxesAmount = number_format((float) $total - ($total / .0975 / .05) , 2, '.', '');
$orderDetails = $this->Session->read('Order.OrderDetail');
//todo get the order here for the seo tags
//$total = $this->Session->read('Order.Order.total');
?>

<script>
	dataLayer.push({
	'event':'order_complete payment',
			'restaurant':{
				'name':<?php echo json_encode($location['Location']['name'], JSON_UNESCAPED_UNICODE); ?>,
				'acceptOnlineOrders':'accept online orders',
				'isOpen':'is currently open',
				'cuisineType':<?php echo json_encode(empty($location['Cuisine'][0]['name_en']) ? '' : $location['Cuisine'][0]['name_en'], JSON_UNESCAPED_UNICODE); ?>,
				'distance': <?php echo $distance; ?>,
				'deliveryTime': <?php echo json_encode($location['Location']['delivery_average_time']. ' minutes', JSON_UNESCAPED_UNICODE); ?>,
				'deliveryMinimum':20,
				'rating':'<?php echo $location['Location']['rating']; ?>'
			},
			'order':{
				'price':<?php echo number_format((float) $this->Session->read('Order.Order.total'), 2, '.', ''); ?>,
				'tip':<?php echo number_format((float) $this->Session->read('Order.Order.tip'), 2, '.', ''); ?>,
				'mode':'<?php echo $this->Session->read('Order.Order.type'); ?>',
				'deliveryCharge': <?php echo number_format((float) $this->Session->read('Order.Order.delivery_charge'), 2, '.', ''); ?>
				'paymentMethod':'<?php echo $this->Session->read('Order.Order.method_of_payment'); ?>'
			}
			'transactionId': '<?php echo $this->Session->read['Order']['Order']['id']; ?>',
			'transactionAffiliation': <?php echo json_encode($location['Location']['name'], JSON_UNESCAPED_UNICODE); ?>,
			'transactionTotal': <?php echo number_format((float) $this->Session->read('Order.Order.total'), 2, '.', ''); ?>,
			'transactionTax': <?php echo $taxesAmount ?>,
			'transactionShipping': <?php echo number_format((float) $this->Session->read('Order.Order.delivery_charge'), 2, '.', ''); ?>,
			'transactionTip': <?php echo number_format((float) $this->Session->read('Order.Order.tip'), 2, '.', ''); ?>,
			'transactionProducts': [
			<?php foreach ($orderDetails as $od): ?>
			{
				'sku': '<?php echo $od['menu_item_id']; ?>',
				'name': <?php echo json_encode($od['name'], JSON_UNESCAPED_UNICODE); ?>,
				'category': 'not implemented',
				'price': <?php echo number_format((float) $od['subtotal'], 2, '.', ''); ?>,
				'quantity': <?php echo $od['quantity']; ?>
			},
			<?php endforeach; ?>
			],
			'visitor':{
			'status':'customer'
			}
	});

</script>