<div class="accordion" id="accordion3">		
    <!-- Location's address -->
    <div class="accordion-group">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseOne">
			<div class="accordion-heading category-no-image">					
				<div class="caption caption-no-image">	
					<p>
						<?php echo __('Address'); ?> <img src="/img/icon_collapsible.png" class="icon_collapsible" alt="">						
					</p>
				</div>						
			</div>
		</a>       

        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
				<p>
					<span class="strong"><?php echo $locationInfo['Location']['name'] ?></span><br/>
					<?php echo $locationInfo['Location']['building_number'] ?>&nbsp;
					<?php echo $locationInfo['Location']['street'] ?>,<br/>
					<?php echo $locationInfo['Location']['city'] ?>&nbsp;
					(<?php echo $locationInfo['Location']['province'] ?>)<br/>
					<?php echo $locationInfo['Location']['postal_code'] ?>
				</p>

				<?php if (!empty($locationInfo['Cuisine'])) { ?>
					<div>									
						<strong>
							<?php echo __('Cuisine type: '); ?>				
						</strong>
						<ul>
							<?php foreach ($locationInfo['Cuisine'] as $c) { ?>
								<li> <?php echo $c['name'] ?></li>
							<?php } ?>
						</ul>

						<div>
						<?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	
    <!-- Location's description -->
    <div class="accordion-group">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseOne">
			<div class="accordion-heading category-no-image">					
				<div class="caption caption-no-image">	
					<p>
						<?php echo __('Description'); ?> <img src="/img/icon_collapsible.png" class="icon_collapsible" alt="">						
					</p>
				</div>						
			</div>
		</a>       

        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
				<p>
					<?php echo $locationInfo['Location']['description']; ?>
				</p>

				<?php if (!empty($locationInfo['Cuisine'])) { ?>
					<div>									
						<strong>
							<?php echo __('Cuisine type: '); ?>				
						</strong>
						<ul>
							<?php foreach ($locationInfo['Cuisine'] as $c) { ?>
								<li> <?php echo $c['name'] ?></li>
							<?php } ?>
						</ul>

						<div>
						<?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Location's schedule -->
	<?php if (!empty($locationInfo['Schedule'])) { ?>

		<div class="accordion-group">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
				<div class="accordion-heading category-no-image">					
					<div class="caption caption-no-image">	
						<p>
							<?php echo __('Opening Hours'); ?> <img src="/img/icon_collapsible.png" class="icon_collapsible" alt="">						
						</p>
					</div>						
				</div>
			</a>           


			<div id="collapseThree" class="accordion-body collapse in">
				<div class="accordion-inner">
					<table class="simple">
						<?php //TODO MOVE THIS IN CONTROLLER AND MODEL?>
						<?php for ($index = 0; $index < 7; $index++) : ?>
							<tr>
								<td class="strong">
									<?php
									switch ($index) {
										case 0:
											echo __('Sunday : ');
											break;
										case 1:
											echo __('Monday : ');
											break;
										case 2:
											echo __('Tuesday : ');
											break;
										case 3:
											echo __('Wenesday : ');
											break;
										case 4:
											echo __('Thursday : ');
											break;
										case 5:
											echo __('Friday : ');
											break;
										case 6:
											echo __('Saturday : ');
											break;
									}
									?>
								</td>
							</tr><tr>
								<td style="padding-bottom: 10px">
									<?php if (!empty($locationInfo['Schedule'][$index]['delivery_start1'])) : ?>
										<table>
											<tr>
												<td><?php echo __('From:') ?></td>
												<td><?php echo $locationInfo['Schedule'][$index]['delivery_start1']; ?></td>
											</tr>

											<?php // For Splited day schedules (ex.: From 11h to 13h and from 16h to 22h)?>
											<?php if ($locationInfo['Schedule'][$index]['split_delivery_time']) : ?>
												<tr>
													<td><?php echo __('to'); ?></td>
													<td><?php echo $locationInfo['Schedule'][$index]['delivery_end2']; ?></td>
												</tr>
												<tr>
													<td><?php echo __('and from'); ?></td>
													<td><?php echo $locationInfo['Schedule'][$index]['delivery_start2']; ?></td>
												</tr>

											<?php endif; ?>
											<tr>
												<td><?php echo __('to:'); ?></td>
												<td><?php echo $locationInfo['Schedule'][$index]['delivery_end1']; ?></td>
											</tr>
										</table>
									<?php else : ?>
										<?php echo __('Closed'); ?>
									<?php endif; ?>
								</td>
							</tr>                    
						<?php endfor; ?>       
					</table>
				</div>
			</div>
		</div>

</div>
	<?php }