<footer class="footer container">
	<div class="container">	
		<div class="col-xs-12 col-md-4">
			<ul class="list-group">
				<li class="list-group-item">
					<?php echo $this->Html->link(__('Privacy and Terms'), array('controller' => 'pages', 'action' => 'display', 'terms')); ?>
				</li>
				<li class="list-group-item">
					<?php echo $this->Html->link(__('Terms and Conditions of Use and Sale'), array('controller' => 'pages', 'action' => 'terms_conditions')); ?>
				</li>
				<li class="list-group-item">
					<?php echo $this->Html->link(__('Coupons Terms and Conditions'), array('controller' => 'pages', 'action' => 'coupons_legal')); ?>
				</li>
				<li class="list-group-item">
					<?php
					echo $this->Html->link(
						__('Customer service'), 'popupex.html', array('onclick' => "return popitup('http://www.providesupport.com/?messenger=topmenuweb')"));
					?>
				</li>
			</ul>
		</div>

		<div class="col-xs-12 col-md-4">
			<ul class="list-group">
				<li class="list-group-item">
					<i class="ion-social-twitter-outline"></i> <a href="https://twitter.com/topmenuweb" class="twitter-follow-button" data-show-count="false" data-lang="fr" data-size="large"><?php echo __('Follow Us'); ?> @topmenuweb</a>
				</li>
				<li class="list-group-item">
					<i class="ion-ios-telephone-outline"></i> <a href="tel:514-989-1233">514-989-1233</a>
				</li>
				<li class="list-group-item">
					<i class="ion-ios-email-outline"></i> <?php echo $this->Html->link(__('Contact us by email'), array('controller' => 'contacts', 'action' => 'index'), array('escape' => false)); ?>
				</li>
				<li class="list-group-item">
					<?php echo __('Businesses: '); ?>
					<?php
					echo $this->Html->link(__('Add Restaurant').' <i class="ion-plus-round"></i> ', array(
						'controller' => 'restaurants',
						'action' => 'add_restaurant'), array('class' => 'btn btn-danger', 'escape' => false));
					?>
				</li>
			</ul>
		</div>
		<div class="col-xs-12 col-md-4">
			<ul class="list-group">
				<li class="list-group-item">
					<p><i class="ion-card"></i> <?php echo __('Accepted Payment Methods'); ?></p>
				</li>
				<li class="list-group-item">
					<?php
						echo $this->Html->image('vi_mc_logos.png', array(
								'width' => 'auto',
								'height' => 70
							)
						);
					?>
				</li>
			</ul>
		</div>
	</div>
</footer>