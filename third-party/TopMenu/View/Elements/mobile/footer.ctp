<div id="mobile-not_logo">
	<div class="btn-group dropup">
		<a class="btn dropdown-toggle btn-inverse mobile_menu_dropdown" data-toggle="dropdown" href="#">
			<?php echo __('Menu'); ?> ▲
		</a>
		<ul class="dropdown-menu pull-right">
			<li>
				<?php
				echo $this->Html->link(__('Contact'), array(
					'controller' => 'contacts',
					'action' => 'index'));
				?>
			</li>
			<li>
				<?php
				echo $this->Html->link(
						__('Customer service'), 'popupex.html', array('onclick' => "return popitup('http://www.providesupport.com/?messenger=topmenuweb')"));
				?>
			</li>
			<li>
				
				<?php echo $this->Html->link(__('Terms and conditions'), array('controller' => 'pages','action' => 'terms')); ?>
			</li>
			<li>
				<a href="<?php echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=desktop;path=/';"><?php echo __('Full site') ?></a>
			</li>

		</ul>	
	</div>
</div>