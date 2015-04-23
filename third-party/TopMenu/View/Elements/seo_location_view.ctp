<?php

// GOOGLE TAG STUFF INSERTE IN THE LAYOUT
if(!$isPdfLocation || $locationIsOnline === TRUE){
	$acceptOnlineOrders = 'accept online orders';
}else{
	$acceptOnlineOrders = 'does not accept online orders';
}
$cuisineType = json_encode(empty($location['Cuisine'][0]['name_en']) ? '' : $location['Cuisine'][0]['name_en'], JSON_UNESCAPED_UNICODE);
$isOpen = ($isDelivering) ? 'is currently open' : 'is currently close';
$distance = $this->Session->check('Location.distance') ? $this->Session->read('Location.distance') : '';
$distance = empty($distance) ? 'null' : number_format((float) $distance / 100, 1, '.', '');
$deliveryTime = empty($location['Location']['delivery_average_time']) ? '45 minutes' : $location['Location']['delivery_average_time'] . 'minutes';
$deliveryMinimum = empty($minOrder) ? 0 : number_format((float) $minOrder, 2, '.', '');
$seoRating = empty($location['Location']['rating']) ? 'not rated' : $location['Location']['rating'];
$seoDeliveryCharge = number_format((float) $deliveryCharge, 2, '.', '');
$locationName = json_encode($location['Location']['name'], JSON_UNESCAPED_UNICODE);
// Javascript injected in layout (in the google tag js)
$additional_dataLayer = <<<EOF

dataLayer.push({
  'restaurant':{
	'name': $locationName,
    'acceptOnlineOrders':'$acceptOnlineOrders',
    'isOpen': '$isOpen',
    'cuisineType': $cuisineType,
    'distance': $distance,
    'deliveryTime':'$deliveryTime',
    'deliveryMinimum': $deliveryMinimum, 
    'rating':'$seoRating'
  },
  order:{
    'mode':'$delType',
    'deliveryCharge':$seoDeliveryCharge 
  }
});

EOF;

// Place in layout
$this->set('additional_dataLayer', $additional_dataLayer);


// Call the injected code if this referer is not itself
if ($this->request->referer() != Router::url($this->request->here, true) && $this->request->referer() != Router::url(array('controller' => 'user', 'action' => 'login'))):
	?>
	<script>
		dataLayer.push({
			'event': 'restaurant_view page restaurant'
		});
	</script>
<?php endif; ?>

	<!-- SEO TIP -->
<?php if(!empty($tipAmount)): ?>
	<script>
		dataLayer.push({
			'event':'restaurant_add tip',
			'order':{
				'tip': <?php echo $tipAmount; ?>
			}
			});
	</script>

<?php endif; ?>

	<!-- SEO ADD ITEM TO  ORDER -->
<?php if(!empty($seoItem)): ?>
	<script>
		dataLayer.push({
			'event':'restaurant_add product',
			'product':{
			  'name':'<?php echo $seoItem['name_en'] ?>',
			  'category':'<?php echo $seoItem['cat_name_en'] ?>',
			  'hasPicture':'<?php echo $seoItem['image'] ?>'
			},
		'order':{
		  'price':<?php echo $seoItem['subtotal'] ?>
		}
});
	</script>

<?php endif;