<?php 
$distance = $this->Session->check('Location.distance') ? $this->Session->read('Location.distance') : '';
$distance = empty($distance) ? 'null' : number_format((float) $distance / 100, 1, '.', ''); 
?>
dataLayer.push({
  'restaurant':{
  'name':<?php echo json_encode($location['Location']['name'], JSON_UNESCAPED_UNICODE); ?>,
    'acceptOnlineOrders':'accept online orders',
    'isOpen':'is currently open',
    'cuisineType': <?php echo json_encode (empty($location['Cuisine'][0]['name_en']) ? '' : $location['Cuisine'][0]['name_en'], JSON_UNESCAPED_UNICODE); ?>,
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
  }
});
