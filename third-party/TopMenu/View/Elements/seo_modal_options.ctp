<script>
	dataLayer.push({
		'event':'restaurant_view dialog product description',
		'product':{
			'name':'<?php echo $itemOptions['MenuItem']['name_en'] ?>',
			'category':'<?php echo $itemOptions['MenuCategory']['name_en'] ?>',
			'hasPicture':'<?php echo $itemOptions['MenuItem']['image'] ? 'product with picture' : 'product without picture' ?>'
  }
});
</script>