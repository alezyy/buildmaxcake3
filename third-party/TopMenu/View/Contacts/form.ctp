<div class="other_center">
	<div class="gray_head_box">
		<div class="gray_head_heading">
			<h1>TOPMENU.COM</h1>
		</div>
	</div>
	<div class="location_view">
		<div>
			<p class="strong">
			 	<?php echo __("225 rue Chabanel suite 1001, 10<sup>th</sup> floor"); ?><br/>
				<?php echo __("Montreal (Quebec)"); ?><br/>
				<?php echo __("H2N 2C9"); ?><br/>
				<?php echo __("Tel.514-989-1233"); ?><br/>
				<?php echo __("Fax.514-989-2905"); ?>
			</p>
		</div>

		<h2><?php echo __('Contact Form'); ?></h2>

		<?php echo $this->Form->create('Contact'); ?>

		<fieldset>
			<legend><?php echo __('Your information'); ?></legend>
			<?php
			echo $this->Form->input('first_name', array('size' => 80));
			echo $this->Form->input('last_name', array('size' => 80));
			echo $this->Form->input('email', array('size' => 80));
			echo $this->Form->input('phone', array('size' => 80));
			echo $this->Form->input(__('type'), 
				array(		
					'options' => array(
						__('client') => __('Client'),
						__('restaurant') => __('Restaurant owner')),
				'label' => __('Client/Restaurant')));
		?>
		</fieldset>

		<fieldset>
			<legend><?php echo __('Your Message'); ?></legend>
			<?php echo $this->Form->input('message', array('cols' => 60, 'rows' => 5)); ?>
		</fieldset>

		<?php echo $this->Form->input(__('Send'), array(
			'type' => 'submit',
			'label' => FALSE,
			'class' => 'btn btn-success pull-right'));
		?>
		<?php echo $this->Form->end(); ?>
	</div>
	
</div>