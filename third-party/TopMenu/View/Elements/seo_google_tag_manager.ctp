		<!-- Google Tag Manager -->
		<?php if (!$admin): ?>	
			<script>
			var dataLayer = dataLayer || [];
			dataLayer.push({
			  'page':{
				'language':'<?php echo $langSuffix; ?>',
				'deviceVersion':'desktop'
			  }
			});
			// Insert additional dataLayer properties here
			<?php echo empty($additional_dataLayer)? '' : $additional_dataLayer; ?>
			</script>
			<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W5HVWR"
							  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-W5HVWR');</script>

			<?php if($this->Session->read('justSignIn', TRUE)):?>
			<script>
				dataLayer.push({
				  'event':'account_complete login',
				  'visitor':{
					'status':'registered<?php echo $this->Session->check('DeliveryDestination') ? ' with a delivery address' : ''; ?>'
				  }
				});
			</script>
			<?php $this->Session->delete('justSignIn'); ?>
			<?php endif; ?>
		
		<?php endif; ?>
		<!-- End Google Tag Manager -->