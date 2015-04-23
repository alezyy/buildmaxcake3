<table>
	<tr>
		<td class="left">
			<p>
				<?php echo $this->Html->link(__('Contact us by email'), array('controller' => 'contacts', 'action' => 'index')); ?>
			</p>	
			<p>
                <?php echo __('Customer Service: '); ?><a href="tel:514 989 1233">514 989 1233</a>                
			</p>	
			<div class="fb-like" data-href="https://topmenu.com/" data-width="30 px" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>		
		</td>

		<td class="middle">
			<p>
				<?php
				echo $this->Html->link(
					__('Customer service'), 'popupex.html', array('onclick' => "return popitup('http://www.providesupport.com/?messenger=topmenuweb')"));
				?>
			</p>
			<p>
				<?php echo $this->Html->link(__('Privacy and Terms'), array('controller' => 'pages', 'action' => 'display', 'terms')); ?>
			</p>
		</td>
		<td class="right">
			<p>
				<?php echo __('Businesses: '); ?>
				<?php
				echo $this->Html->link(__('Add Restaurant'), array(
					'controller' => 'restaurants',
					'action' => 'add_restaurant'), array('class' => 'btn btn-danger'));
				?>
			</p>
		</td>
	</tr>
	<tr>
		<td class="left">
			<div id="fb-root"></div>
			<a href="https://twitter.com/topmenuweb" class="twitter-follow-button" data-show-count="false" data-lang="fr" data-size="large"><?php echo __('Follow Us'); ?> @topmenuweb</a>
		</td>
		<td class="middle" >
			<p id="credit-card-logo">
				<?php
				echo $this->Html->image('visa.png');
				echo $this->Html->image('mastercard.png');
				?>
			</p>
		</td>
		<td class="right">
			<p>
				<a href="<?php echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=mobile;path=/';"><?php echo __('Mobile site') ?></a>
			</p>
		</td>
	</tr>

</table>