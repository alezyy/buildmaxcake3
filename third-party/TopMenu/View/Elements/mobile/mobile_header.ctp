
<div class="header-logo">
	
	<?php
	echo $this->Html->link(
		$this->Html->image('topmenu_logo_40.png'), array(
		'controller' => 'homes',
		'action' => 'index',
		'language' => $langSuffix,
		'admin' => false), array(
		'escape' => false));
	?>
	
</div>
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
        echo Router::url($changeLanguageUrl);  // do not use get text for this string (because on the french site we want the english written in english)?>"/>
</div>

