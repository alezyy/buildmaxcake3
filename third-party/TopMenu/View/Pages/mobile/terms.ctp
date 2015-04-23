<div id="content_inner">
	<div class="other_center">
		<div class="gray_head_box">
			<div class="gray_head_heading"><h1><?php echo __('Privacy and Terms'); ?></h1></div>
		</div>

		<div class="location_view">			
			<nav>
				<ul>
					<li>
						<?php echo $this->Html->link(__("Privacy Policy"), array('controller' => 'pages', 'action' => 'confidentiality')); ?>
					</li>	
					<li>
						<?php echo $this->Html->link(__('Terms and Conditions of Use and Sale'), array('controller' => 'pages', 'action' => 'terms_conditions')); ?>
					</li>	
					<li>
						<?php echo $this->Html->link(__('Coupons Terms and Conditions'), array('controller' => 'pages', 'action' => 'coupons_legal')); ?>
					</li>	
				</ul>
			</nav>			
		</div>
	</div>
</div>