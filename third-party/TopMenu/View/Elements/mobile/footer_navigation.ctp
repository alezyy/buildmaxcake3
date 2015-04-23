<div class="footer_items_title_home mT30 mB10">
	<?php echo __('Browse by City'); ?>     
</div>

<div class="column" style="float:left">


	<?php
	// Split the sectors list into 4 columns
	$city_counter = 0;
	?>

	<?php foreach ($sectorsList as $sector): ?>
		<?php if ($city_counter % $rowsByColSec == 0): ?>
		<div class="column" style="float:left">
		<?php endif; ?>

		<div class="footer_item_list_inner">
			<?php
			echo $this->Html->link(
				$sector['Sector']['title'],
				array(
					'controller' => 'locations',
					'action'     => 'search',
					'sector'     => $sector['Sector']['url']
				)
			);
			?>      
		</div>
		<?php 
		$city_counter++; 
		if ($city_counter % $rowsByColSec == 0): 
		?>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>   
</div>
<div class="clear"></div>