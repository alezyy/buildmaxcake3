<div id="password_meter_div" style="display:none;">
	<div id="password_meter" class="progress progress-danger progress-striped active" style="margin-right:5px;width:240px;">
		<div class="bar" style="width: 0%;">
			<div id="weak" style="color:black;"><?php echo __('Weak'); ?></div>
			<div id="average" style="display:none;"><?php echo __('Average'); ?></div>
			<div id="strong" style="display:none;"><?php echo __('Strong'); ?></div>
			<div id="verystrong" style="display:none;"><?php echo __('Very Strong'); ?></div>
		</div>
	</div>
	<div>
		<?php
		echo __('Password must be \'Average\' or stronger. Passwords require at least one uppercase letter.');
		?>
	</div>
</div>
<div id="meter_title" style="display:none;">
	<?php echo __('Password Strength'); ?>
</div>

<div id="pw_match" style="display:none;">
	<?php echo __('Password match!'); ?>
</div>