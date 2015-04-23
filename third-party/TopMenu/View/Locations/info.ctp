<div class="space">
	<div class="col-xs-12 col-md-8">
		<h5 class="text-red"><strong><?php echo __('Description'); ?></strong></h5>
		<?php echo $locationInfo['Location']['description']; ?>
		<?php if (!empty($locationInfo['Schedule'])) : ?>
			<div class="col-xs-12 no-padding">
				<h5 class="text-red"><strong><i class="fa fa-calendar-o"></i> <?php echo __('Opening Hours'); ?></strong><h5/>
				<div class="row">

					
				<?php for ($index = 0; $index < 7; $index++) : ?>
					
					<div class="col-xs-1">
						<strong><?php echo $this->Schedule->_dayOfWeekString($index); ?></strong>	
					</div>
					<div class="col-xs-11">
						<?php if ($locationInfo['Schedule'][$index]['delivery_start1'] == $locationInfo['Schedule'][$index]['delivery_end1']) : ?>
							<i><?php echo __('Closed'); ?></i>
						<?php else : ?>
							
							<div class="">
								
								<?php // For Splited day schedules (ex.: From 11h to 13h and from 16h to 22h)?>
								<?php if ($locationInfo['Schedule'][$index]['split_delivery_time']) : ?>
									
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_start1'])); ?></span>
										<span><?php echo __(' - '); ?></span>
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_end1'])); ?></span>
									
										<i><?php echo __('---------  '); ?></i>
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_start2'])); ?></span>
										
										<span><?php echo __(' - '); ?></span>
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_end2'])); ?></span>

								<?php else: ?>
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_start1'])); ?></span>
										<span><?php echo __(' - '); ?></span>
										<span><?php echo date('H:i',strtotime($locationInfo['Schedule'][$index]['delivery_end1'])); ?></span>
								<?php endif; ?>

							</div>
						<?php endif; ?>
					</div>                    
				<?php endfor; ?>       
				</div>
			</div>
		<?php endif ?>
	</div>

	<?
	  // Override any of the following default options to customize your map
		$address = $locationInfo['Location']['building_number'] .", ".$locationInfo['Location']['street'] .", ". $locationInfo['Location']['city'] .", ". $locationInfo['Location']['province'];
	  $map_options = array(
	    'id' => 'map_canvas',
	    'width' => 'auto',
	    'height' => '250px',
	    'style' => '',
	    'zoom' => 17,
	    'localize' => false,
	    'type' => 'ROADMAP',
	    'custom' => null,
	    'address' => $address,
	    'marker' => true,
	    'markerTitle' => $locationInfo['Location']['name'],
	    'markerIcon' => 'home_page/map_icon.png',
	    'infoWindow' => true,
	    'windowText' => $locationInfo['Location']['name']
	  );
	?>


	<address class="col-xs-12 col-md-4">
		<?= $this->GoogleMap->map($map_options); ?>
		<h5 class="text-red"><strong><i class="fa fa-map-marker"></i> <?php echo __('Address'); ?></strong><h5/>
		<?php echo $locationInfo['Location']['building_number'] ?>&nbsp;
		<?php echo $locationInfo['Location']['street'] ?>,<br/>
		<?php echo $locationInfo['Location']['city'] ?>&nbsp;
		(<?php echo $locationInfo['Location']['province'] ?>)<br/>
		<?php echo $locationInfo['Location']['postal_code'] ?>
	</address>
</div>