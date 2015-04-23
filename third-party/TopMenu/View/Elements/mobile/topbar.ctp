<div id="mobile-header">
	<div style="width: 100%;">
		
		<div class="header-controls">
			<div class="header_sprite_button" id="header_search_button_<?php echo $langSuffix ?>"></div>
			<input type="hidden" class="header_link" value="<?php echo Router::url('/', true) ?>" />
		</div>
		<div class="header-controls">
			<div class="header_sprite_button" id="header_<?php echo (empty($user_id)) ? 'signin' : 'logout'; ?>_button_<?php echo $langSuffix ?>"></div>
			<input type="hidden" 
				   class="header_link"
				   value="<?php
				   if (!$user_id) {
					   echo Router::url(array(
						   'controller' => 'users',
						   'action' => 'login',
						   'language' => $langSuffix,
						   'admin' => false), true);
				   } else {
					   echo Router::url(array(
						   'controller' => 'users',
						   'action' => 'logout',
						   'language' => $langSuffix,
						   'admin' => false), true);
				   }
				   ?>"/>
		</div>
		<div class="header-controls">
			<div class="header_sprite_button" id="header_language_button_<?php echo $language ?>" ></div>
			<input type="hidden" class="header_link" value="<?php
				   if ($language == 'fr') :
					   echo Router::url('/en' . substr($this->request->here, 3), true);
				   else:
					   echo Router::url('/fr' . substr($this->request->here, 3), true);
				   endif;
				   ?>"/>
		</div>
	</div>
</div>

<script>
	
	// transform the div into links
	$('.header-controls').click(function(){
		window.location =$(this).find('input').val();
		
	})
</script>
